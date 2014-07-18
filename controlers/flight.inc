<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/flight.inc';

class FlightControler extends BaseControler {
  private $model;
  private $view;

  public function FlightControler() {
    $this->view = dirname(__FILE__) . '/../templates/flight.php';
    $this->model = new Flight();
  }

  private function Validate() {
    foreach ($_POST['date'] as $key => $value) {
      if (empty($value)) {
        Messages::form_error('date[' . $key . ']', "Data negali būti tuščia.");
      }
    }
    foreach ($_POST['user_student'] as $key => $value) {
      if (empty($value)) {
        Messages::form_error('user_student[' . $key . ']', "Mokinys/Mokėtojas negali būti tuščias.");
      }
    }
    foreach ($_POST['price'] as $key => $value) {
      if (empty($value) || !is_numeric($value)) {
        Messages::form_error('price[' . $key . ']', "Kaina negali būti tuščia arba ne skaičius.");
      }
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  public function NewItem() {
    //$this->view = dirname(__FILE__) . '/../views/flight/edit.php';
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
        foreach ($_POST['date'] as $key => $value) {
          $data = array();
          foreach ($_POST as $_key => $_value) {
            if (isset($_value[$key]))
              $data[$_key] = $_value[$key];
          }
          $flight->storeFormValues($data);

          print_r($_POST);
          die;

          if ($flight->insert()) {
            //create payment
            if (!empty($flight->amount)) {
              require_once dirname(__FILE__) . '/../models/finance.inc';
              $finance = Finance::getByUserId();
              $finance->flight_fee = floatval($finance->flight_fee) - $flight->amount;
              $finance->update();
            }

            //log it
            log_event("Admin", "FlightCreated", $flight->id);
          }
          else {
            Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
          }
          Messages::set_message("Pakeitimai išsaugoti.");
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
    if (empty($_GET['callsign']) || !($flight = Flight::getByCallsign($_GET['callsign']))) {
      Messages::set_message("Orlaivis nerastas.", 'errors');
    }
    else {
      $flight->delete();
      log_event("Admin", "FlightDeleted", $_GET['callsign']);

      Messages::set_message("Orlaivis pašalintas.");
    }
	  $this->Transfer(NULL, 'ItemList');
    //return $this->ItemList();
  }

  public function Edit() {
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
          $flight->storeFormValues($_POST);
          if ($flight->update()) {
            //log it
            log_event("Admin", "FlightEdited", $_POST['id']);
            Messages::set_message("Pakeitimai išsaugoti.");

            $this->Transfer(NULL, 'ItemList');
            //return $this->ItemList();
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
    else if (!empty($_GET['callsign'])) {
      // User has not posted the flight edit form yet: display the form
      $results['flight'] = Flight::getByCallsign($_GET['callsign']);
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

    $data = Flight::getList();
    $results = array('flights' => $data['results'], 'totalRows' => $data['totalRows']);

    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
