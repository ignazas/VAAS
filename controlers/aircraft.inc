<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/aircraft.inc';

class AircraftControler extends BaseControler {
  private $model;
  private $view;

  public function AircraftControler() {
    $this->view = dirname(__FILE__) . '/../templates/aircraft.php';
    $this->model = new Aircraft();
  }

  private function Validate() {
    if (empty($_POST['name'])) {
      Messages::form_error('name', "Modelis negali būti tuščias.");
    }

    if (empty($_POST['reg_num'])) {
      Messages::form_error('reg_num', "Registracija negali būti tuščia.");
    }
    elseif (mb_strlen($_POST['reg_num'], 'utf-8') > 6) {
      Messages::form_error('reg_num', "Registracijos ilgis negali viršyti 6 simbolių.");
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  public function NewItem() {
    if (!$this->HasPermission())
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/aircraft/edit.php';

    $results = array(
      'pageTitle' => "Naujas orlaivis",
      'formAction' => "NewItem",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      $aircraft = new Aircraft();
      $results['aircraft'] = $aircraft;

      if ($this->Validate()) {
        $aircraft->storeFormValues($_POST);
        $aircraft->id = empty($aircraft->id) ? NULL : $aircraft->id;
        if ($aircraft->insert()) {
          //log it
          log_event("Admin", "AircraftCreated", $aircraft->id);
          Messages::set_message("Pakeitimai išsaugoti.");

          $this->Transfer(NULL, 'ItemList');
        }
        else {
          Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
        }
      }
      include dirname(__FILE__) . '/../views/_layout.php';
    }
    elseif (isset($_POST['cancel'])) {
      // User has cancelled their edits: return to the aircraft list
      $this->Transfer(NULL, 'ItemList');
    }
    else {
      // User has not posted the aircraft edit form yet: display the form
      $results['aircraft'] = new Aircraft();

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Delete() {
    if (!$this->HasPermission())
      $this->Transfer();

    if (empty($_GET['id']) || !($aircraft = Aircraft::getById($_GET['id']))) {
      Messages::set_message("Orlaivis nerastas.", 'errors');
    }
    else {
      $aircraft->delete();
      log_event("Admin", "AircraftDeleted", $_GET['id']);

      Messages::set_message("Orlaivis pašalintas.");
    }
	  $this->Transfer(NULL, 'ItemList');
  }

  public function Edit() {
    if (!$this->HasPermission())
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/aircraft/edit.php';

    $results = array(
      'pageTitle' => "Orlaivio redagavimas",
      'formAction' => "Edit",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      if (!($aircraft = Aircraft::getById($_POST['id']))) {
        Messages::set_message("Orlaivis $_POST[id] nerastas.", 'errors');

        include dirname(__FILE__) . '/../views/_layout.php';
      }
      else {
        $results['aircraft'] = $aircraft;
        if ($this->Validate()) {
          $aircraft->storeFormValues($_POST);
          if ($aircraft->update()) {
            //log it
            log_event("Admin", "AircraftEdited", $_POST['id']);
            Messages::set_message("Pakeitimai išsaugoti.");

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
      // User has cancelled their edits: return to the aircraft list
      $this->Transfer(NULL, 'ItemList');
    }
    else if (!empty($_GET['id'])) {
      // User has not posted the aircraft edit form yet: display the form
      $results['aircraft'] = Aircraft::getById($_GET['id']);
      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Index() {
    return $this->ItemList();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/aircraft/view.php';

    if (isset($_GET["id"])) {
      $results = array('aircraft' => Aircraft::getById($_GET["id"]));
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
