<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/service.inc';

class ServiceControler extends BaseControler {
  private $model;
  private $view;

  public function ServiceControler() {
    $this->view = NULL;
    $this->model = new Service();
  }

  private function Validate() {
    if (empty($_POST['title'])) {
      Messages::form_error('title', "Pavadinimas negali būti tuščias.");
    }
    elseif (mb_strlen($_POST['title'], 'utf-8') > 256) {
      Messages::form_error('description', "Pavadinimas ilgis negali viršyti 256 simbolių.");
    }

    if (mb_strlen($_POST['description'], 'utf-8') > 256) {
      Messages::form_error('description', "Aprašymo ilgis negali viršyti 256 simbolių.");
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  public function NewItem() {
    $this->view = dirname(__FILE__) . '/../views/service/edit.php';

    $results = array(
      'pageTitle' => "Naujas paslauga",
    );

    $edit = array();
    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      $service = new Service();
      $results['service'] = $service;
      $edit = $_POST;

      if ($this->Validate()) {
        $service->storeFormValues($_POST);
        if ($service->insert()) {
          //log it
          log_event("Admin", "ServiceCreated", $service->id);
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
    elseif (isset($_POST['cancel'])) {
      // User has cancelled their edits: return to the service list
      $this->Transfer(NULL, 'ItemList');
      //return $this->ItemList();
    }
    else {
      // User has not posted the service edit form yet: display the form
      $results['service'] = new Service(array());

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Delete() {
    if (empty($_GET['id']) || !($service = Service::getById($_GET['id']))) {
      Messages::set_message("Paslauga nerasta.", 'errors');
    }
    else {
      $service->delete();
      log_event("Admin", "ServiceDeleted", $_GET['id']);

      Messages::set_message("Paslauga pašalinta.");
    }
    $this->Transfer(NULL, 'ItemList');
    //return $this->ItemList();
  }

  public function Edit() {
    $this->view = dirname(__FILE__) . '/../views/service/edit.php';

    $results = array(
      'pageTitle' => "Edit Service",
    );

    $edit = array();
    if (isset($_POST['saveChanges'])) {
      // User has posted the service edit form: save the service changes
      if (!($service = Service::getById($_POST['id']))) {
        Messages::set_message("Paslauga $_POST[id] nerasta.", 'errors');

        include dirname(__FILE__) . '/../views/_layout.php';
      }
      else {
        $results['service'] = $service;
        $edit = $_POST;

        if ($this->Validate()) {
          $service->storeFormValues($_POST);
          if ($service->update()) {
            //log it
            log_event("Admin", "ServiceEdited", $_POST['id']);
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
      // User has cancelled their edits: return to the service list
      $this->Transfer(NULL, 'ItemList');
      //return $this->ItemList();
    }
    else if (!empty($_GET['id'])) {
      // User has not posted the service edit form yet: display the form
      $service = Service::getById($_GET['id']);
      $results['service'] = $service;
      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Index() {
    return $this->ItemList();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/service/view.php';

    if ($_GET["id"]) {
      $service = Service::getById($_GET["id"]);
      $results = array('service' => $service);
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
