<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/flight.inc';
require_once dirname(__FILE__) . '/../models/practice_data.inc';
require_once dirname(__FILE__) . '/../helpers/date.inc';
require_once dirname(__FILE__) . '/../models/user.inc';
require_once dirname(__FILE__) . '/../models/service.inc';

class FlightControler extends BaseControler {
  private $view;

  public function FlightControler() {
    $this->view = dirname(__FILE__) . '/../templates/flight.php';
  }

  private function Validate() {
    if (isset($_POST['date']) && is_array($_POST['date'])) {
      foreach ($_POST['date'] as $key => $value) {
        if (empty($value)) {
          Messages::form_error('date[' . $key . ']', "Data negali būti tuščia.");
        }
      }
      foreach ($_POST['payer'] as $key => $value) {
        if (empty($value)) {
          Messages::form_error('payer[' . $key . ']', "Mokinys/Pirkėjas negali būti tuščias.");
        }
      }
      foreach ($_POST['airplane_id'] as $key => $value) {
        if (empty($value)) {
          Messages::form_error('airplane_id[' . $key . ']', "Orlaivis negali būti nenurodytas.");
        }
      }
      foreach ($_POST['price'] as $key => $value) {
        if (!empty($value) && !is_numeric($value)) {
          Messages::form_error('price[' . $key . ']', "Kaina negali būti tuščia arba ne skaičius.");
        }
      }
    }
    else {
      if (empty($_POST['date'])) {
        Messages::form_error('date', "Data negali būti tuščia.");
      }
      if (empty($_POST['payer'])) {
        Messages::form_error('payer', "Mokinys/Pirkėjas negali būti tuščias.");
      }
      if (empty($_POST['airplane_id'])) {
        Messages::form_error('airplane_id', "Orlaivis negali būti nenurodytas.");
      }
      if (empty($_POST['price']) || !is_numeric($_POST['price'])) {
        Messages::form_error('price', "Kaina negali būti tuščia arba ne skaičius.");
      }
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  private function ValidateData($data) {
    if (empty($data['date'])) {
      Messages::form_error('date', "Data negali būti tuščia.");
    }

    if (empty($data['practice_id'])) {
      Messages::form_error('practice_id', "Praktika turi būti pasirinkta.");
    }

    if (empty($data['user_id'])) {
      Messages::form_error('user_id', "Mokinys turi būti nurodytas.");
    }

    if (!empty($data['count'])) {
      if (empty($data['aircraft_id'])) {
        Messages::form_error('aircraft_id', "Sklandytuvas turi būti pasirinktas.");
      }
    }
    //else {
    //  Messages::form_error('count', "Skrydžių kiekis turi būti nurodytas.");
    //}

    if (empty($data['time'])) {
      Messages::form_error('time', "Skrydžių laikas turi būti nurodytas.");
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  public function NewItem() {
    if (!$this->HasPermission('Flight Manager'))
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/flight/new.php';

    $results = array(
      'pageTitle' => "New Flight",
      'formAction' => "newFlight",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes

      if ($this->Validate()) {
        $success = array();
        $fail = array();
        foreach ($_POST['date'] as $key => $value) {
          $data = array();
          foreach ($_POST as $_key => $_value) {
            if (isset($_value[$key]))
              $data[$_key] = $_value[$key];
          }
          $data['task'] = empty($data['practice']) ? NULL : $data['practice'];
          $data['duration'] = DateHelper::time_as_float($data['time']);

          $practice_data = NULL;
          if (!empty($data['practice'])) {
            $data['user_id'] = $data['payer'];
            $data['instructor_id'] = $data['instructor'];
            $data['practice_id'] = $data['practice'];
            $data['aircraft_id'] = $data['airplane_id'];
            $data['count'] = $data['amount'];
            //$data['time'] = DateHelper::time_as_float($data['time']);
            $data['comments'] = '';

            $practice_data = new PracticeData($data);
            if (empty($practice_data->date))
              $practice_data->date = date('Y-m-d');

            if (!$this->ValidateData($data)) {
              Messages::set_message("Klaida išsaugant praktikos reikšmes.", 'errors');
              $fail[] = $key;
              continue;
            }
          }

          $flight = new Flight();
          $flight->storeFormValues($data);
          if ($flight->insert()) {
            //create payment
            $finance = NULL;
            if (!empty($flight->price)) {
              require_once dirname(__FILE__) . '/../models/finance.inc';
              $finance = Finance::getByUserId($flight->payer);
              $finance->flight_fee = floatval($finance->flight_fee) - $flight->price;
              $finance->fee_notes = "Už $flight->date skrydį.";
              $finance->update();

              $user = User::Get($flight->payer);
              Messages::set_message("Nuskaityta suma iš piloto $user->name už skrydį: $flight->price €.");

              log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
                (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($flight->price) ? '; price added: ' . (-$flight->price) : NULL)));
            }

            if (!empty($flight->instructor)){
              $instructor = User::Get($flight->instructor);
              $instructorSalary = Service::get_instructor_salary();
              if (!empty($instructor) && !empty($instructorSalary) && !empty($instructorSalary->amount)) {
                if ($instructorSalary->is_price_for_duration && !empty($flight->duration)) {
                  $price = $instructorSalary->amount * $flight->duration;
                }
                else if (!empty($flight->amount)) {
                  $price = $instructorSalary->amount * $flight->amount;
                }
                if (!empty($price))
                  $price = round($price);

                if (!empty($price)) {
                  $finance = Finance::getByUserId($flight->instructor);
                  $finance->flight_fee = floatval($finance->flight_fee) + $price;
                  $finance->fee_notes = "Už $flight->date skrydžio instruktavimą.";
                  $finance->update();
                  Messages::set_message("Priskaityta suma instruktoriui $instructor->name už skrydžius: $price €.");
                
                  log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
                    (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($price) ? '; price added: ' . $price : NULL)));
                }
              }
            }
            
            if (!empty($practice_data)) {
              if ($practice_data->insert()) {
                //log it
                log_event("Admin", "PracticeDataCreated", $practice_data->id);
                Messages::set_message("Praktikos įrašas sukurtas.");

                $flight->task = $practice_data->id;
                $flight->update();
              }
              else {
                Messages::set_message("Klaida išsaugant praktikos reikšmes.", 'errors');
                $fail[] = $key;
              }
            }

            //log it
            log_event("Admin", "FlightCreated", 'flight id: ' . $flight->record_id . ', price: ' . $_POST['price'][$key] . (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id));

            $success[] = $key;
          }
          else {
            Messages::set_message("Klaida išsaugant reikšmes.", 'errors');

            $fail[] = $key;
          }
        }
        if (!empty($success)) {
          foreach ($success as $key)
            if (isset($_POST['date'][$key])) unset($_POST['date'][$key]);
          if (empty($fail))
            Messages::set_message("Pakeitimai išsaugoti.");
          else
            Messages::set_message("Dalis pakeitimų išsaugoti. Atvaizduojamos eilutės, kurių išsaugoti nepavyko");
        }

        if (empty($fail)) {
          $this->Transfer(NULL, 'ItemList');
        }
      }
      include dirname(__FILE__) . '/../views/_layout.php';
    }
    elseif (isset($_POST['cancel'])) {
      // User has cancelled their edits: return to the flight list
      $this->Transfer(NULL, 'ItemList');
      //return $this->ItemList();
    }
    else {
      // User has not posted the flight edit form yet: display the form
      $results['flight'] = new Flight(array('callsign' => ''));

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Delete() {
    if (!$this->HasPermission('Flight Manager'))
      $this->Transfer();

    $date = NULL;
    if (empty($_GET['record_id']) && !empty($_GET['id'])) $_GET['record_id'] = $_GET['id'];
    if (empty($_GET['record_id']) || !($flight = Flight::getById($_GET['record_id']))) {
      Messages::set_message("Skrydžio įrašas nerastas.", 'errors');
    }
    else {
      $date = $flight->date;
      $finance = NULL;
      if (!empty($flight->price)) {
        require_once dirname(__FILE__) . '/../models/finance.inc';
        $finance = Finance::getByUserId($flight->payer);
        $finance->flight_fee = floatval($finance->flight_fee) + $flight->price;
        $finance->fee_notes = "Už $flight->date skrydį.";
        $finance->update();

        $user = User::Get($flight->payer);
        Messages::set_message("$user->name gražinta suma: $flight->price €.");

        //log it
        log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
          (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($flight->price) ? '; price added: ' . $flight->price : NULL)));
      }

      if (!empty($flight->instructor)){
        $instructor = User::Get($flight->instructor);
        $instructorSalary = Service::get_instructor_salary();
        if (!empty($instructor) && !empty($instructorSalary) && !empty($instructorSalary->amount)) {
          if ($instructorSalary->is_price_for_duration && !empty($flight->duration)) {
            $price = $instructorSalary->amount * $flight->duration;
          }
          else if (!empty($flight->amount)) {
            $price = $instructorSalary->amount * $flight->amount;
          }
          if (!empty($price))
            $price = round($price);
          
          if (!empty($price)) {
            $finance = Finance::getByUserId($flight->instructor);
            $finance->flight_fee = floatval($finance->flight_fee) - $price;
            $finance->fee_notes = "Už $flight->date skrydžio instruktavimą.";
            $finance->update();
            Messages::set_message("Susigražinta suma už skrydžius iš instruktoriaus $instructor->name: $price €.");
            
            log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
              (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($price) ? '; price added: ' . (-$price) : NULL)));
          }
        }
      }

      if (!empty($flight->task)) {
        $practice_data = new PracticeData(array('id' => $flight->task));
        $practice_data->delete();
        //log it
        log_event("Admin", "PracticeDataDeleted", 'task id: ' . $flight->task);
      }

      $flight->delete();

      //log it
      log_event("Admin", "FlightDeleted", 'flight id: ' . $flight->record_id . (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id));

      Messages::set_message("Skrydis pašalintas.");
    }
	  $this->Transfer(NULL, 'ItemList', array('date' => $date));
    //return $this->ItemList();
  }

  public function Edit() {
    if (!$this->HasPermission('Flight Manager'))
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/flight/edit.php';

    $results = array(
      'pageTitle' => "Edit Flight",
      'formAction' => "editFlight",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      if (!($flight = Flight::getById($_POST['id']))) {
        Messages::set_message("Skrydis $_POST[id] nerastas.", 'errors');

        include dirname(__FILE__) . '/../views/_layout.php';
      }
      else {
        $results['flight'] = $flight;
        $_POST['duration'] = DateHelper::time_as_float($_POST['duration']);

        if ($this->Validate()) {
          $price_before_update = empty($flight->price) ? 0 : $flight->price;
          $payer_before_update = empty($flight->payer) ? NULL : $flight->payer;
          $instructor_before_update = empty($flight->instructor) ? NULL : $flight->instructor;
          $flight->storeFormValues($_POST);
          if ($flight->update()) {
            $diff = 0;
            $finance = NULL;
            if ($flight->price != $price_before_update) {
              require_once dirname(__FILE__) . '/../models/finance.inc';
              if ($payer_before_update == $flight->payer) {
                $diff = ((empty($flight->price) ? 0 : $flight->price) - $price_before_update);
                if (!empty($diff)) {
                  //charge difference
                  $finance = Finance::getByUserId($flight->payer);
                  $finance->flight_fee = floatval($finance->flight_fee) - $diff;
                  $finance->fee_notes = "Už $flight->date skrydį.";
                  $finance->update();

                  $user = User::Get($flight->payer);
                  Messages::set_message($diff > 0 ? "Papildomai nuskaityta už atnaujintą skrydį iš piloto $user->name: $diff €." : "Susigražinta permokėta suma už atnaujintą skrydį pilotui $user->name: ".(-$diff)." €.");

                  //log it
                  log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
                    (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($diff) ? '; price changed: ' . $diff : NULL)));
                }
              }
              else {
                //return money
                if (!empty($payer_before_update) && !empty($price_before_update)) {
                  $finance = Finance::getByUserId($payer_before_update);
                  $finance->flight_fee = floatval($finance->flight_fee) + $price_before_update;
                  $finance->fee_notes = "Už $flight->date skrydį.";
                  $finance->update();
                  $user = User::Get($flight->payer);
                  Messages::set_message("Buvusiam mokėtojui $user->name sugražinta apmokėta suma: $price_before_update €.");

                  //log it
                  log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
                    (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($price_before_update) ? '; price returned: ' . $price_before_update : NULL)));
                }

                //take money
                if (!empty($flight->payer) && !empty($flight->price)) {
                  $finance = Finance::getByUserId($flight->payer);
                  $finance->flight_fee = floatval($finance->flight_fee) - $flight->price;
                  $finance->fee_notes = "Už $flight->date skrydį.";
                  $finance->update();
                  $user = User::Get($flight->payer);
                  Messages::set_message("Pilotui $user->name nuskaityta suma už skrydį: $flight->price €.");

                  //log it
                  log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
                    (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($flight->price) ? '; price charged: ' . $flight->price : NULL)));
                }
              }

              if ($flight->instructor != $instructor_before_update) {
                $instructor = User::Get($instructor_before_update);
                $instructorSalary = Service::get_instructor_salary();
                if (!empty($instructor) && !empty($instructorSalary) && !empty($instructorSalary->amount)) {
                  if ($instructorSalary->is_price_for_duration && !empty($flight->duration)) {
                    $price = $instructorSalary->amount * $flight->duration;
                  }
                  else if (!empty($flight->amount)) {
                    $price = $instructorSalary->amount * $flight->amount;
                  }
                  if (!empty($price))
                    $price = round($price);
                  
                  if (!empty($price)) {
                    $finance = Finance::getByUserId($flight->instructor);
                    $finance->flight_fee = floatval($finance->flight_fee) - $price;
                    $finance->fee_notes = "Už $flight->date skrydžio instruktavimą.";
                    $finance->update();
                    Messages::set_message("Susigražinta suma už skrydžius iš instruktoriaus $instructor->name: $price €.");
                    
                    log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
                      (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($price) ? '; price added: ' . (-$price) : NULL)));
                  }
                }
              }
              
              if (!empty($flight->instructor)){
                $instructor = User::Get($flight->instructor);
                $instructorSalary = Service::get_instructor_salary();
                if (!empty($instructor) && !empty($instructorSalary) && !empty($instructorSalary->amount)) {
                  if ($instructorSalary->is_price_for_duration && !empty($flight->duration)) {
                    $price = $instructorSalary->amount * $flight->duration;
                  }
                  else if (!empty($flight->amount)) {
                    $price = $instructorSalary->amount * $flight->amount;
                  }
                  if (!empty($price))
                    $price = round($price);
                  
                  if (!empty($price)) {
                    $finance = Finance::getByUserId($flight->instructor);
                    $finance->flight_fee = floatval($finance->flight_fee) + $price;
                    $finance->fee_notes = "Už $flight->date skrydžio instruktavimą.";
                    $finance->update();
                    Messages::set_message("$instructor->name priskaityta suma už skrydžius: $price €.");
                    
                    log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
                      (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($price) ? '; price added: ' . (-$price) : NULL)));
                  }
                }
              }
            }

            Messages::set_message("Pakeitimai išsaugoti.");

            log_event("Admin", "FlightEdited", 'flight id: ' . $flight->record_id);

            $this->Transfer(NULL, 'ItemList');
          }
          else {
            Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
          }
        }

        require_once dirname(__FILE__) . '/../models/service.inc';
        $services = Service::getList(1000000, 'title', 'is_flight=1');
        $users = User::getList();
        $instructors = User::getList(1000000, 'u.name', '`instructor`=1');
        require_once dirname(__FILE__) . '/../models/aircraft.inc';
        $airplanes = Aircraft::getList();

        include dirname(__FILE__) . '/../views/_layout.php';
      }
    }
    elseif (isset($_POST['cancel'])) {
      // User has cancelled their edits: return to the flight list
      $this->Transfer(NULL, 'ItemList');
      //return $this->ItemList();
    }
    else if (!empty($_GET['id'])) {
      // User has not posted the flight edit form yet: display the form
      $results['flight'] = Flight::getById($_GET['id']);

      require_once dirname(__FILE__) . '/../models/service.inc';
      $services = Service::getList(1000000, 'title', 'is_flight=1');
      require_once dirname(__FILE__) . '/../models/user.inc';
      $users = User::getList();
      $instructors = User::getList(1000000, 'u.name', '`instructor`=1');
      require_once dirname(__FILE__) . '/../models/aircraft.inc';
      $airplanes = Aircraft::getList();

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Index() {
    return $this->ItemList();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/flight/view.php';

    if (isset($_GET["callsign"])) {
      $results = array('flight' => Flight::getByCallsign($_GET["callsign"]));
    } elseif ($_GET["id"]) {
      $results = array('flight' => Flight::getById($_GET["id"]));
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function ItemList() {
    $this->view = dirname(__FILE__) . '/../views/flight/item-list.php';

    if (!isset($_GET['date']))
      $_GET['date'] = date('Y-m-d');

    $filters = array();
    if (!empty($_GET['date'])) {
      $escaped = DB::escape($_GET['date']);
      $filters[] = "date = $escaped";
    }

    $results = array(
      'flights' => Flight::getList(NULL, !empty($_GET['order']) ? $_GET['order'] : '-date', implode(' AND ', $filters)),
    );

    require_once dirname(__FILE__) . '/../models/user.inc';
    $data = User::getList();
    $results['users'] = array();
    foreach ($data['results'] as $user)
      $results['users'][$user->id] = $user;

    require_once dirname(__FILE__) . '/../models/service.inc';
    $data = Service::getList(1000000, 'title', 'is_flight=1');
    $results['services'] = array();
    foreach ($data['results'] as $service)
      $results['services'][$service->id] = $service;

    require_once dirname(__FILE__) . '/../models/aircraft.inc';
    $data = Aircraft::getList();
    $results['airplanes'] = array();
    foreach ($data['results'] as $airplane)
      $results['airplanes'][$airplane->id] = $airplane;

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function Download() {
    if (!$this->HasPermission('Flight Manager'))
      $this->Transfer();

    $date = empty($_GET['date']) ? date('Y-m-d') : $_GET['date'];
    $filters = array();

    $escaped = DB::escape($_GET['date']);
    $filters[] = "date = $escaped";

    $flights = Flight::getList(NULL, !empty($_GET['order']) ? $_GET['order'] : '-date', implode(' AND ', $filters));

    $source = dirname(__FILE__) . '/../templates/word/chronometrazas.docx';
    $newFile = dirname(__FILE__) . "/../uploads/flights/chronometrazas " . date('Y-m-d') . '.docx';

    require_once dirname(__FILE__) . '/../libraries/PHPWord.php';
    require_once dirname(__FILE__) . '/../helpers/date.inc';

    require_once dirname(__FILE__) . '/../models/service.inc';
    require_once dirname(__FILE__) . '/../models/user.inc';
    require_once dirname(__FILE__) . '/../models/aircraft.inc';

    // New Word Document
    $PHPWord = new PHPWord();

    $document = $PHPWord->loadTemplate($source);

    $total_count = 0;
    $total_time = 0;
    if (!empty($flights['totalRows'])) {
      $document->cloneRow('AIRCRAFT_TYPE', $flights['totalRows']);

      $i = 0;
      foreach ($flights['results'] as $flight) {
        $i++;

        $task = empty($flight->service_id) ? NULL : Service::getById($flight->service_id);
        $pilot = empty($flight->payer) ? NULL : User::Get($flight->payer);
        $instructor = empty($flight->instructor) ? NULL : User::Get($flight->instructor);
        $aircraft = empty($flight->airplane_id) ? NULL : Aircraft::getById($flight->airplane_id);

        $document->setValue('AIRCRAFT_TYPE#'.$i, empty($aircraft) ? '' : $aircraft->name);
        $document->setValue('AIRCRAFT_REGISTRATION_NO#'.$i, empty($aircraft) ? '' : $aircraft->reg_num);
        $document->setValue('PILOT#'.$i, empty($pilot) ? '' : $pilot->name);
        $document->setValue('INSTRUCTOR#'.$i, empty($instructor) ? '' : $instructor->name);
        $document->setValue('TASK#'.$i, empty($task) ? '' : $task->title);
        $document->setValue('FLIGHT_COUNT#'.$i, $flight->amount);
        $document->setValue('FLIGHT_TIME#'.$i, DateHelper::time_as_string($flight->duration));

        $total_count += $flight->amount;
        $total_time += DateHelper::time_as_float($flight->duration);
      }
    } else {
        $document->setValue('AIRCRAFT_TYPE', '');
        $document->setValue('AIRCRAFT_REGISTRATION_NO', '');
        $document->setValue('PILOT', '');
        $document->setValue('INSTRUCTOR', '');
        $document->setValue('TASK', '');
        $document->setValue('FLIGHT_COUNT', '');
        $document->setValue('FLIGHT_TIME', '');
    }

    $document->setValue('TOTAL_FLIGHTS', $total_count);
    $document->setValue('TOTAL_TIME', DateHelper::time_as_string($total_time));

    $document->setValue('YEAR', date('Y', strtotime($date)));
    $document->setValue('MONTH', date('m', strtotime($date)));
    $document->setValue('DAY', date('d', strtotime($date)));

    $document->save($newFile);

    if (file_exists($newFile)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename='.basename($newFile));
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($newFile));
      flush();
      readfile($newFile);

      unlink($newFile);
      exit;
    }

    Messages::set_message('Nepavyko sugeneruoti failo');
    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
