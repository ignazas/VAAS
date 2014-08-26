<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/finance.inc';

class FinanceControler extends BaseControler {
  private $model;
  private $view;

  public function FinanceControler() {
    $this->view = dirname(__FILE__) . '/../templates/finance.php';
    $this->model = new Finance();
  }

  private function Validate() {
    if (empty($_POST['contact_id']) || !is_numeric($_POST['contact_id'])) {
      Messages::form_error('contact_id', "Nenurodytas vartotojas.");
    }
    if (!empty($_POST['entry_fee']) && !is_numeric($_POST['entry_fee'])) {
      Messages::form_error('entry_fee', "Priėmimo mokestis negali būti ne skaičius.");
    }
    if (!empty($_POST['member_fee']) && !is_numeric($_POST['member_fee'])) {
      Messages::form_error('member_fee', "Nario mokestis negali būti ne skaičius.");
    }
    if (!empty($_POST['labor_fee']) && !is_numeric($_POST['labor_fee'])) {
      Messages::form_error('labor_fee', "Darbų/talkos mokestis negali būti ne skaičius.");
    }
    if (!empty($_POST['house_fee']) && !is_numeric($_POST['house_fee'])) {
      Messages::form_error('house_fee', "Namelio nuoma negali būti ne skaičius.");
    }
    if (!empty($_POST['electricity_fee']) && !is_numeric($_POST['electricity_fee'])) {
      Messages::form_error('electricity_fee', "Elektros mokestis negali būti ne skaičius.");
    }
    if (!empty($_POST['airworthiness_fee']) && !is_numeric($_POST['airworthiness_fee'])) {
      Messages::form_error('airworthiness_fee', "Airworthiness mokestis negali būti ne skaičius.");
    }
    if (!empty($_POST['insurance_fee']) && !is_numeric($_POST['insurance_fee'])) {
      Messages::form_error('insurance_fee', "Draudimas negali būti ne skaičius.");
    }
    if (!empty($_POST['casco_fee']) && !is_numeric($_POST['casco_fee'])) {
      Messages::form_error('casco_fee', "Kasko mokestis negali būti ne skaičius.");
    }
    if (!empty($_POST['flight_fee']) && !is_numeric($_POST['flight_fee'])) {
      Messages::form_error('flight_fee', "Skrydžių mokestis negali būti ne skaičius.");
    }
    if (!empty($_POST['debt_fee']) && !is_numeric($_POST['debt_fee'])) {
      Messages::form_error('debt_fee', "Už 2% mokestis negali būti ne skaičius.");
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  public function Edit() {
    if (!$this->HasPermission())
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/finance/edit.php';

    $results = array(
      'pageTitle' => "Redaguoti finansus",
      'formAction' => "Edit",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      if (!($finance = Finance::get($_POST['contact_id']))) {
        Messages::set_message("Mokestis nerastas.", 'errors');
        $this->Transfer(NULL, 'ItemList');
      }
      else {
        $results['finance'] = $finance;
        if ($this->Validate()) {
          $finance->storeFormValues($_POST);
          if ($finance->update()) {
            //log it
            log_event("Admin", "FinanceEdited", $_POST['contact_id']);
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
      // User has cancelled their edits: return to the finance list
      $this->Transfer(NULL, 'ItemList');
      //return $this->ItemList();
    }
    else if (!empty($_GET['id'])) {
      // User has not posted the finance edit form yet: display the form
      $results['finance'] = Finance::getByUserId($_GET['id']);
      require_once dirname(__FILE__) . '/../models/user.inc';
      $results['finance']->user = User::Get($_GET['id']);
      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Index() {
    return $this->ItemList();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/finance/view.php';

    if (isset($_GET["id"])) {
      $results = array(
        'finance' => Finance::get($_GET["id"]),
        'journal' => Finance::get_payments($_GET["id"])
      );
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function ItemList() {
    $this->view = dirname(__FILE__) . '/../views/finance/item-list.php';

    $data = Finance::getList();
    $results = array('finances' => $data['results'], 'totalRows' => $data['totalRows']);

    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
