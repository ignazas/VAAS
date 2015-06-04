<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../helpers/user.inc';
require_once dirname(__FILE__) . '/../models/user.inc';
require_once dirname(__FILE__) . '/../models/practice.inc';
require_once dirname(__FILE__) . '/../models/practice_data.inc';
require_once dirname(__FILE__) . '/../models/aircraft.inc';

class PracticeControler extends BaseControler {
  private $view;

  public function PracticeControler() {
    $this->view = dirname(__FILE__) . '/../templates/practice.php';
  }

  private function ValidateComment() {
    if (empty($_POST['date'])) {
      Messages::form_error('date', "Data negali būti tuščia.");
    }

    if (empty($_POST['practice_id'])) {
      Messages::form_error('practice_id', "Praktika turi būti pasirinkta.");
    }

    if (empty($_POST['user_id'])) {
      Messages::form_error('user_id', "Mokinys turi būti nurodytas.");
    }

    if (!empty($_POST['count'])) {
      if (empty($_POST['aircraft_id'])) {
        Messages::form_error('aircraft_id', "Sklandytuvas turi būti pasirinktas.");
      }
    }
    //else {
    //  Messages::form_error('count', "Skrydžių kiekis turi būti nurodytas.");
    //}

    //if (empty($_POST['time'])) {
    //  Messages::form_error('time', "Skrydžių laikas turi būti nurodytas.");
    //}

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  private function ValidateData() {
    if (empty($_POST['date'])) {
      Messages::form_error('date', "Data negali būti tuščia.");
    }

    if (empty($_POST['practice_id'])) {
      Messages::form_error('practice_id', "Praktika turi būti pasirinkta.");
    }

    if (empty($_POST['user_id'])) {
      Messages::form_error('user_id', "Mokinys turi būti nurodytas.");
    }

    if (!empty($_POST['count'])) {
      if (empty($_POST['aircraft_id'])) {
        Messages::form_error('aircraft_id', "Sklandytuvas turi būti pasirinktas.");
      }
    }
    //else {
    //  Messages::form_error('count', "Skrydžių kiekis turi būti nurodytas.");
    //}

    if (empty($_POST['time'])) {
      Messages::form_error('time', "Skrydžių laikas turi būti nurodytas.");
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  public function NewComment() {
    $_GET['id'] = NULL;
    return $this->EditComment();
  }

  public function EditComment() {
    //if (!$this->HasPermission('Flight Manager'))
    //  $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/practice_data/edit-comment.php';

    $results = array(
      'pageTitle' => "New Practice Data Comment",
      'formAction' => "newPracticeDataComment",
    );

    $practice_data = NULL;
    if (empty($_GET['id']) || !($practice_data = PracticeData::getById($_GET['id']))) {
      $practice_data = new PracticeData($_GET);
      if (empty($practice_data->date))
        $practice_data->date = date('Y-m-d');
    }

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the practice_data changes
      $results['practice_data'] = $practice_data;

      if ($this->ValidateComment()) {
        $practice_data->storeFormValues($_POST);
        $practice_data->time = DateHelper::time_as_string($practice_data->time);
        if (!empty($practice_data->id)) {
          if ($practice_data->update()) {
            //log it
            log_event("Admin", "PracticeDataUpdated", $practice_data->id);
            Messages::set_message("Pakeitimai išsaugoti.");

            $this->Transfer(NULL, 'DataItemList');
          }
          else {
            Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
          }
        }
        else {
          $practice_data->id = NULL;
          if ($practice_data->insert()) {
            //log it
            log_event("Admin", "PracticeDataCreated", $practice_data->id);
            Messages::set_message("Pakeitimai išsaugoti.");

            $this->Transfer(NULL, 'ItemList');
          }
          else {
            Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
          }
        }
      }
    }
    elseif (isset($_POST['cancel'])) {
      // User has cancelled their edits: return to the practice list
      $this->Transfer(NULL, 'ItemList');
    }

    $results['aircrafts'] = Aircraft::getList();
    $results['practices'] = Practice::getList();
    $results['practice_data'] = $practice_data;

    // User has not posted the practice data edit form yet: display the form
    if ($this->HasPermission('Flight Manager')) {
      $results['users'] = User::getList();
    }
    else {
      $user_id = UserHelper::get_id();
      if (!empty($practice_data->id) && $practice_data->user_id != $user_id) {
        $this->Transfer(NULL, 'ItemList');
      }
      else {
        $practice_data->user_id == $user_id;
        $results['users'] = array ( "results" => array(User::Get($user_id)), "totalRows" => 1 );
      }
    }
    $results['instructors'] = User::getList(1000000, 'u.name', 'u.instructor=1');

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function NewData() {
    $_GET['id'] = NULL;
    return $this->EditData();
  }

  public function EditData() {
    if (!$this->HasPermission('Flight Manager'))
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/practice_data/edit.php';

    $results = array(
      'pageTitle' => "New Practice Data",
      'formAction' => "newPracticeData",
    );

    $practice_data = NULL;
    if (empty($_GET['id']) || !($practice_data = PracticeData::getById($_GET['id']))) {
      //can not add new - only edit!
      $this->Transfer();

      $practice_data = new PracticeData($_GET);
      if (empty($practice_data->date))
        $practice_data->date = date('Y-m-d');
    }

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the practice_data changes
      $results['practice_data'] = $practice_data;

      if ($this->ValidateData()) {
        $practice_data->storeFormValues($_POST);
        $practice_data->time = DateHelper::time_as_string($practice_data->time);
        if (!empty($practice_data->id)) {
          if ($practice_data->update()) {
            //log it
            log_event("Admin", "PracticeDataUpdated", $practice_data->id);
            Messages::set_message("Pakeitimai išsaugoti.");

            $this->Transfer(NULL, 'DataItemList');
          }
          else {
            Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
          }
        }
        else {
          $practice_data->id = NULL;
          if ($practice_data->insert()) {
            //log it
            log_event("Admin", "PracticeDataCreated", $practice_data->id);
            Messages::set_message("Pakeitimai išsaugoti.");

            $this->Transfer(NULL, 'ItemList');
          }
          else {
            Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
          }
        }
      }
    }
    elseif (isset($_POST['cancel'])) {
      // User has cancelled their edits: return to the practice list
      $this->Transfer(NULL, 'ItemList');
    }

    $results['aircrafts'] = Aircraft::getList();
    $results['practices'] = Practice::getList();
    $results['practice_data'] = $practice_data;

    // User has not posted the practice data edit form yet: display the form
    if ($this->HasPermission('Flight Manager')) {
      $results['users'] = User::getList();
    }
    else {
      $user_id = UserHelper::get_id();
      if (!empty($practice_data->id) && $practice_data->user_id != $user_id) {
        $this->Transfer(NULL, 'ItemList');
      }
      else {
        $practice_data->user_id == $user_id;
        $results['users'] = array ( "results" => array(User::Get($user_id)), "totalRows" => 1 );
      }
    }
    $results['instructors'] = User::getList(1000000, 'u.name', 'u.instructor=1');

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function DeleteData() {
    if (!$this->HasPermission('Flight Manager'))
      $this->Transfer();

    if (empty($_GET['id']) || !($practice_data = PracticeData::getById($_GET['id']))) {
      Messages::set_message("Skrydžio įrašas nerastas.", 'errors');
    }
    else {
      $practice_data->delete();

      //log it
      log_event("Admin", "PracticeDataDeleted", 'id: ' . $practice_data->id);

      Messages::set_message("Praktikos duomenys pašalinti.");
    }
	  $this->Transfer(NULL, 'DataItemList');
    //return $this->ItemList();
  }

  public function Index() {
    return $this->ItemList();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/practice_data/view.php';

    if (!empty($_GET["id"])) {
      $results = array('practice_data' => Practice::getById($_GET["id"]));
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function ItemList() {
    $this->view = dirname(__FILE__) . '/../views/practice/item-list.php';

    $data = Practice::getList(NULL, !empty($_GET['order']) ? $_GET['order'] : NULL);
    $user_id = empty($_GET['user_id']) ? UserHelper::get_id() : $_GET['user_id'];
    $results = array(
      'practice' => $data,
      'user' => empty($user_id) ? NULL : User::Get($user_id),
      'practice_data' => PracticeData::getStatistic($user_id),
    );

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function DataItemList() {
    $this->view = dirname(__FILE__) . '/../views/practice_data/item-list.php';

    if ($this->HasPermission('Flight Manager')) {
      $user_id = empty($_GET['user_id']) ? NULL : $_GET['user_id'];
    }
    else {
      $user_id = empty($_GET['user_id']) ? UserHelper::get_id() : $_GET['user_id'];
    }
    $data = PracticeData::getList($user_id, !empty($_GET['order']) ? $_GET['order'] : NULL);
    foreach ($data['results'] as $practice) {
        $practice->user = User::Get($practice->user_id);
        $practice->instructor = User::Get($practice->instructor_id);
        $practice->practice = Practice::getById($practice->practice_id);
        $practice->aircraft = Aircraft::getById($practice->aircraft_id);
    }

    $results = array(
      'practice_data' => $data,
      'user' => empty($user_id) ? NULL : User::Get($user_id),
    );

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function Download() {
    if (!$this->HasPermission('Flight Manager'))
      $this->Transfer();

    throw new Exception('Not implemented');

    $date = empty($_GET['date']) ? date('Y-m-d') : $_GET['date'];
    $filters = array();

    $escaped = DB::escape($_GET['date']);
    $filters[] = "date = $escaped";

    $flights = Flight::getList(NULL, !empty($_GET['order']) ? $_GET['order'] : '-date', implode(' AND ', $filters));
    $flights['results'];
    $flights['totalRows'];

    $source = dirname(__FILE__) . '/../templates/word/practice.docx';
    $newFile = dirname(__FILE__) . "/../uploads/flights/practice " . date('Y-m-d') . '.docx';

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
