<?php

require_once dirname(__FILE__) . '/base.inc';

class AnalysisControler extends BaseControler {
  private $model;
  private $view;

  public function AnalysisControler() {
  }

  public function Index() {
    return $this->View();
  }

  private function Upload($user_id) {
    if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
      $valid_formats = array("igc");
      $max_file_size = 1024*1024; //1mb
      $path = dirname(__FILE__) . "/../uploads/logs/"; // Upload directory
      $count = 0;

      // Loop $_FILES to exeicute all files
      foreach ($_FILES['files']['name'] as $f => $name) {
        if ($_FILES['files']['error'][$f] == 4) {
          continue; // Skip file if any error found
        }
        if ($_FILES['files']['error'][$f] == 0) {
          if ($_FILES['files']['size'][$f] > $max_file_size) {
            Messages::set_message("$name is too large.", 'errors');
            continue; // Skip large files
          }
          elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
            Messages::set_message("$name is not a valid format.", 'errors');
            continue; // Skip invalid file formats
          }
          else{ // No error found! Move uploaded files
            if (!file_exists($path . $user_id)) {
              if (mkdir($path . $user_id, 0777, TRUE) === FALSE) {
                Messages::set_message("$name Can not create destination directory.", 'errors');
              }
            }
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path . $user_id . '/' . $name))
              $count++; // Number of successfully uploaded file
          }
        }
      }
    }
  }

  public function Delete() {
    require_once dirname(__FILE__) . '/../helpers/user.inc';
    $user_id = UserHelper::get_id();
    if (empty($user_id))
      $this->Transfer();

    if (!empty($_GET['file']))
      $file = dirname(__FILE__) . '/../uploads/logs/' . $user_id . '/' . urldecode($_GET['file']) . '.igc';
    else {
      $file = NULL;
      foreach ($results['files'] as $f) {
        $file = $f;
      }
    }

    if (file_exists($file)) {
      unlink($file);
      Messages::set_message('Failas ' . basename($file, '.igc') . ' ištrintas');
    }

    $this->Transfer();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/analysis/view.php';

    require_once dirname(__FILE__) . '/../helpers/user.inc';
    $user_id = UserHelper::get_id();
    if (empty($user_id))
      $this->Transfer();

    $this->Upload($user_id);

    $results = array(
      'files' => glob(dirname(__FILE__) . '/../uploads/logs/' . $user_id . '/*.igc'),
    );

    if (!empty($_GET['file']))
      $file = dirname(__FILE__) . '/../uploads/logs/' . $user_id . '/' . urldecode($_GET['file']) . '.igc';
    else {
      $file = NULL;
      if (!empty($results['files'])) {
        foreach ($results['files'] as $f) {
          $file = $f;
        }
      }
    }

    if (file_exists($file)) {
      require_once dirname(__FILE__) . '/../libraries/PHP_IGC/PHP_IGC-0.1.php';
      if (!($igc = new PHP_IGC($file))) {
        Messages::set_message("Klaida nuskaitant igc failą.", 'errors');
        $this->Transfer();
      }
      $igc->setDetails();
      $results['google_maps_code'] =
        $igc->getMap('AIzaSyAe39YF9QPfql88R8lEsD9JMm6OD-Wpazg', NULL, 600) .
        $igc->getAltitude(NULL, 300) .
        $igc->getSpeed(NULL, 300) .
        $igc->getVariometer(NULL, 300);
    }


    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
