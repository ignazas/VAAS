<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/flight.inc';

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
        if (empty($value) || !is_numeric($value)) {
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

  public function NewItem() {
    if (!$this->HasPermission())
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/flight/new.php';

    $results = array(
      'pageTitle' => "New Flight",
      'formAction' => "newFlight",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      $flight = new Flight();
      $results['flight'] = $flight;

      if ($this->Validate()) {
        $success = array();
        $fail = array();
        foreach ($_POST['date'] as $key => $value) {
          $data = array();
          foreach ($_POST as $_key => $_value) {
            if (isset($_value[$key]))
              $data[$_key] = $_value[$key];
          }
          $flight->storeFormValues($data);

          if ($flight->insert()) {
            //create payment
            $finance = NULL;
            if (!empty($flight->price)) {
              require_once dirname(__FILE__) . '/../models/finance.inc';
              $finance = Finance::getByUserId($flight->payer);
              $finance->flight_fee = floatval($finance->flight_fee) - $flight->price;
              $finance->update();

              Messages::set_message("Mokėtojui nuskaityta suma: $flight->price.");

              log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
                (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($diff) ? '; price charged: ' . $flight->price : NULL)));
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
    if (!$this->HasPermission())
      $this->Transfer();

    if (empty($_GET['record_id']) && !empty($_GET['id'])) $_GET['record_id'] = $_GET['id'];
    if (empty($_GET['record_id']) || !($flight = Flight::getById($_GET['record_id']))) {
      Messages::set_message("Skrydžio įrašas nerastas.", 'errors');
    }
    else {
      $finance = NULL;
      if (!empty($flight->price)) {
        require_once dirname(__FILE__) . '/../models/finance.inc';
        $finance = Finance::getByUserId($flight->payer);
        $finance->flight_fee = floatval($finance->flight_fee) + $flight->price;
        $finance->update();

        Messages::set_message("Mokėtojui gražinta suma: $flight->price Lt.");

        //log it
        log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
          (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($diff) ? '; price charged: ' . $flight->price : NULL)));
      }

      $flight->delete();

      //log it
      log_event("Admin", "FlightDeleted", 'flight id: ' . $flight->record_id . (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id));

      Messages::set_message("Skrydis pašalintas.");
    }
	  $this->Transfer(NULL, 'ItemList');
    //return $this->ItemList();
  }

  public function Edit() {
    if (!$this->HasPermission())
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
        if ($this->Validate()) {
          $price_before_update = empty($flight->price) ? 0 : $flight->price;
          $payer_before_update = empty($flight->payer) ? NULL : $flight->payer;
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
                  $finance->update();

                  Messages::set_message($diff > 0 ? "Mokėtojui papildomai nuskaityta: $diff Lt." : "Mokėtojui sugražinta: ".(-$diff)." Lt.");

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
                  $finance->update();
                  Messages::set_message("Buvusiam mokėtojui sugražintas apmokėta suma: $price_before_update Lt.");

                  //log it
                  log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
                    (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($diff) ? '; price returned: ' . $price_before_update : NULL)));
                }

                //take money
                if (!empty($flight->payer) && !empty($flight->price)) {
                  $finance = Finance::getByUserId($flight->payer);
                  $finance->flight_fee = floatval($finance->flight_fee) - $flight->price;
                  $finance->update();
                  Messages::set_message("Naujam mokėtojui nuskaityta suma: $flight->price Lt.");

                  //log it
                  log_event("Admin", "FinanceEdited", 'flight id: ' . $flight->record_id .
                    (empty($finance) ? NULL : '; payment journal: ' . $finance->contact_id . (!empty($diff) ? '; price charged: ' . $flight->price : NULL)));
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

    $data = Flight::getList(NULL, !empty($_GET['order']) ? $_GET['order'] : NULL);
    $results = array('flights' => $data['results'], 'totalRows' => $data['totalRows']);

    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
