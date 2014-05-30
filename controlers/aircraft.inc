<?php

require_once dirname(__FILE__) . '/../models/aircraft.inc';
require_once dirname(__FILE__) . '/../helpers/messages.inc';

class AircraftControler {
  private $model;
  private $view;

  public function AircraftControler() {
    $this->view = dirname(__FILE__) . '/../templates/aircraft.php';
    $this->model = new Aircraft();
  }

  private function Validate() {
    if (empty($_POST['callsign'])) {
      Messages::form_error('callsign', "Registracija negali būti tuščia.");
    }
    elseif (mb_strlen($_POST['callsign'], 'utf-8') > 6) {
      Messages::form_error('callsign', "Registracijos ilgis negali viršyti 6 simbolių.");
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  public function NewItem() {
    $this->view = dirname(__FILE__) . '/../views/aircraft/edit.php';

    $results = array(
      'pageTitle' => "New Aircraft",
      'formAction' => "newAircraft",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      $aircraft = new Aircraft();
      $results['aircraft'] = $aircraft;

      if ($this->Validate()) {
        $aircraft->storeFormValues($_POST);
        if ($aircraft->insert()) {
          //log it
          log_event("Admin", "AircraftCreated", $aircraft->callsign);
          Messages::set_message("Pakeitimai išsaugoti.");

          return $this->ItemList();
        }
        else {
          Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
        }
      }
      include dirname(__FILE__) . '/../views/_layout.php';
    }
    elseif (isset($_POST['cancel'])) {
      // User has cancelled their edits: return to the aircraft list
      return $this->ItemList();
    }
    else {
      // User has not posted the aircraft edit form yet: display the form
      $results['aircraft'] = new Aircraft(array('callsign' => 'LY-G'));

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Delete() {
    if (empty($_GET['callsign']) || !($aircraft = Aircraft::getByCallsign($_GET['callsign']))) {
      Messages::set_message("Orlaivis nerastas.", 'errors');
    }
    else {
      $aircraft->delete();
      log_event("Admin", "AircraftDeleted", $_GET['callsign']);

      Messages::set_message("Orlaivis pašalintas.");
    }
    return $this->ItemList();
  }

  public function Edit() {
    $this->view = dirname(__FILE__) . '/../views/aircraft/edit.php';

    $results = array(
      'pageTitle' => "Edit Aircraft",
      'formAction' => "editAircraft",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      if (!($aircraft = Aircraft::getByCallsign($_POST['old_callsign']))) {
        Messages::set_message("Orlaivis $_POST[old_callsign] nerastas.", 'errors');

        include dirname(__FILE__) . '/../views/_layout.php';
      }
      else {
        $results['aircraft'] = $aircraft;
        if ($this->Validate()) {
          $aircraft->storeFormValues($_POST);
          if ($aircraft->update()) {
            //log it
            log_event("Admin", "AircraftEdited", $_POST['callsign']);
            Messages::set_message("Pakeitimai išsaugoti.");

            return $this->ItemList();
          }
          else {
            Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
          }
        }
        include dirname(__FILE__) . '/../views/_layout.php';
      }
    }
    elseif (isset($_POST['cancel'])) {
      // User has cancelled their edits: return to the aircraft list
      return $this->ItemList();
    }
    else if (!empty($_GET['callsign'])) {
      // User has not posted the aircraft edit form yet: display the form
      $results['aircraft'] = Aircraft::getByCallsign($_GET['callsign']);
      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Index() {
    return $this->ItemList();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/aircraft/view.php';

    if (isset($_GET["callsign"])) {
      $results = array('aircraft' => Aircraft::getByCallsign($_GET["callsign"]));
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function ItemList() {
    $this->view = dirname(__FILE__) . '/../views/aircraft/item-list.php';

    $data = Aircraft::getList();
    $results = array('aircrafts' => $data['results'], 'totalRows' => $data['totalRows']);

    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
