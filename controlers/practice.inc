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
    else {
      Messages::form_error('count', "Skrydžių kiekis turi būti nurodytas.");
    }

    if (empty($_POST['time'])) {
      Messages::form_error('time', "Skrydžių laikas turi būti nurodytas.");
    }

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

  public function Approve() {
    $user_id = UserHelper::get_id();
    if (!empty($_GET['id'])) {
      $practice_data = PracticeData::getById($_GET['id']);
    }

    if (empty($practice_data) || !$this->HasPermission('Flight Manager') && $user_id != $practice_data->instructor_id)
      return FALSE;

    $practice_data->approved = empty($_GET['value']) ? 0 : 1;

    return $practice_data->update();
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
    if (empty($_GET['id']) || !($practice_data = PracticeData::getById($_GET['id']))) {
      Messages::set_message("Skrydžio įrašas nerastas.", 'errors');
    }
    else {
      $user_id = UserHelper::get_id();
      if (!$this->HasPermission('Flight Manager') && ($practice_data->user_id != $user_id || !empty($practice->approved)))
        $this->Transfer();
      
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
    $user = User::Get(UserHelper::get_id());
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

    $source = dirname(__FILE__) . '/../templates/word/Mokymo ataskaita.docx';
    $newFile = dirname(__FILE__) . "/../uploads/flights/Mokymo ataskaita " . date('Y-m-d') . '.docx';

    require_once dirname(__FILE__) . '/../libraries/PHPWord.php';
    require_once dirname(__FILE__) . '/../helpers/date.inc';

    require_once dirname(__FILE__) . '/../models/service.inc';
    require_once dirname(__FILE__) . '/../models/user.inc';
    require_once dirname(__FILE__) . '/../models/aircraft.inc';
    require_once dirname(__FILE__) . '/../models/flight.inc';
    require_once dirname(__FILE__) . '/../models/practice.inc';
    require_once dirname(__FILE__) . '/../models/practice_data.inc';

    // New Word Document
    $PHPWord = new PHPWord();

    $document = $PHPWord->loadTemplate($source);

    $user_id = empty($_GET['user_id']) ? UserHelper::get_id() : $_GET['user_id'];
    $user = User::Get($user_id);

    $document->setValue('PILOT', $user->name);

    $document->setValue('LICENSE_NO', $user->licenseNo);
    $document->setValue('LICENSE_VALID_TILL', empty($user->licenseValidTill)
      ? ''
      : (!is_string($user->licenseValidTill) ? date('Y-m-d', $user->licenseValidTill) : $user->licenseValidTill));
    $document->setValue('HEALTH_NO', $user->healthNo);
    $document->setValue('HEALTH_VALID_TILL',  empty($user->healthValidTill)
      ? ''
      : (!is_string($user->healthValidTill) ? date('Y-m-d', $user->healthValidTill) : $user->healthValidTill));

    $first_flight = Flight::getList(1, 'date', 'payer=' . $user_id);
    $s_date = empty($first_flight['results']) ? date('Y-m-d') : $first_flight['results'][0]->date;
    $document->setValue('S_YEAR', date('Y', strtotime($s_date)));
    $document->setValue('S_MONTH', date('m', strtotime($s_date)));
    $document->setValue('S_DAY', date('d', strtotime($s_date)));

    $last_flight = Flight::getList(1, '-date', 'payer=' . $user_id);
    $e_date = empty($last_flight['results']) ? date('Y-m-d') : $last_flight['results'][0]->date;
    $document->setValue('E_YEAR', date('Y', strtotime($e_date)));
    $document->setValue('E_MONTH', date('m', strtotime($e_date)));
    $document->setValue('E_DAY', date('d', strtotime($e_date)));

    $practice_data = PracticeData::getDetailedStatistic($user_id);

    $phases = array();
    $total = 0;
    $total_with_instructor = 0;
    $total_sav = 0;
    $total_landing_field = 0;
    foreach ($practice_data as $data) {
      if (!isset($phases[$data->phase_no]['total'])) $phases[$data->phase_no]['total'] = 0;
      if (!isset($phases[$data->phase_no]['kontr'])) $phases[$data->phase_no]['kontr'] = 0;
      if (!isset($phases[$data->phase_no]['sav'])) $phases[$data->phase_no]['sav'] = 0;

      if (!empty($data->with_instructor) &&
        ($data->phase_no == 1 && $data->no == 11) ||
        ($data->phase_no == 2 && $data->no == 17))
        $phases[$data->phase_no]['kontr'] += DateHelper::time_as_float($data->time);
      else if (empty($data->with_instructor))
        $phases[$data->phase_no]['sav'] += DateHelper::time_as_float($data->time);
      $phases[$data->phase_no]['total'] += DateHelper::time_as_float($data->time);

      $total += DateHelper::time_as_float($data->time);
      $total_with_instructor += empty($data->with_instructor) ? 0 : DateHelper::time_as_float($data->time);
      $total_sav += !empty($data->with_instructor) ? 0 : DateHelper::time_as_float($data->time);
      if ($data->phase_no == 2 && $data->no == 14)
        $total_landing_field += DateHelper::time_as_float($data->time);
    }

    $document->setValue('1_TOTAL', empty($phases[1]['total']) ? 0 : DateHelper::time_as_string($phases[1]['total']));
    $document->setValue('1_KONTR', empty($phases[1]['kontr']) ? 0 : DateHelper::time_as_string($phases[1]['kontr']));
    $document->setValue('1_SAV', empty($phases[1]['sav']) ? 0 : DateHelper::time_as_string($phases[1]['sav']));
    $document->setValue('2_TOTAL', empty($phases[2]['total']) ? 0 : DateHelper::time_as_string($phases[2]['total']));
    $document->setValue('2_KONTR', empty($phases[2]['kontr']) ? 0 : DateHelper::time_as_string($phases[2]['kontr']));
    $document->setValue('2_SAV', empty($phases[2]['sav']) ? 0 : DateHelper::time_as_string($phases[2]['sav']));

    $document->setValue('TOTAL', DateHelper::time_as_string($total));
    $document->setValue('TOTAL_WITH_INSTRUCTOR', DateHelper::time_as_string($total_with_instructor));
    $document->setValue('TOTAL_SAV', DateHelper::time_as_string($total_sav));
    $document->setValue('TOTAL_LANDING_FIELD', $total_landing_field);

    $lastYearTime = PracticeData::timeInLastYear($user_id);
    $document->setValue('TOTAL_LAST_YEAR', DateHelper::time_as_string($lastYearTime));

    $document->setValue('DATE', date('Y-m-d'));

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
