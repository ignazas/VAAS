<?php

require_once dirname(__FILE__) . '/../models/service.inc';
require_once dirname(__FILE__) . '/../helpers/messages.inc';

class ServiceControler {
  private $model;
  private $view;

  public function ServiceControler() {
    $this->view = dirname(__FILE__) . '/../templates/service.php';
    $this->model = new Service();
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
    $this->view = dirname(__FILE__) . '/../views/service/edit.php';

    $results = array(
      'pageTitle' => "New Service",
      'formAction' => "newService",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      $service = new Service();
      $results['service'] = $service;

      if ($this->Validate()) {
        $service->storeFormValues($_POST);
        if ($service->insert()) {
          //log it
          log_event("Admin", "ServiceCreated", $service->callsign);
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
      // User has cancelled their edits: return to the service list
      return $this->ItemList();
    }
    else {
      // User has not posted the service edit form yet: display the form
      $results['service'] = new Service(array('callsign' => ''));

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Delete() {
    if (empty($_GET['callsign']) || !($service = Service::getByCallsign($_GET['callsign']))) {
      Messages::set_message("Orlaivis nerastas.", 'errors');
    }
    else {
      $service->delete();
      log_event("Admin", "ServiceDeleted", $_GET['callsign']);

      Messages::set_message("Orlaivis pašalintas.");
    }
    return $this->ItemList();
  }

  public function Edit() {
    $this->view = dirname(__FILE__) . '/../views/service/edit.php';

    $results = array(
      'pageTitle' => "Edit Service",
      'formAction' => "editService",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      if (!($service = Service::getById($_POST['id']))) {
        Messages::set_message("Skrydis $_POST[id] nerastas.", 'errors');

        include dirname(__FILE__) . '/../views/_layout.php';
      }
      else {
        $results['service'] = $service;
        if ($this->Validate()) {
          $service->storeFormValues($_POST);
          if ($service->update()) {
            //log it
            log_event("Admin", "ServiceEdited", $_POST['id']);
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
      // User has cancelled their edits: return to the service list
      return $this->ItemList();
    }
    else if (!empty($_GET['callsign'])) {
      // User has not posted the service edit form yet: display the form
      $results['service'] = Service::getByCallsign($_GET['callsign']);
      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Index() {
    return $this->ItemList();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/service/view.php';

    if (isset($_GET["callsign"])) {
      $results = array('service' => Service::getByCallsign($_GET["callsign"]));
    } elseif ($_GET["id"]) {
      $results = array('service' => Service::getById($_GET["id"]));
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function ItemList() {
    $this->view = dirname(__FILE__) . '/../views/service/item-list.php';

    $data = Service::getList();
    $results = array('services' => $data['results'], 'totalRows' => $data['totalRows']);

    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
