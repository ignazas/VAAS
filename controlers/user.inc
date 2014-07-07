<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/user.inc';

class UserControler extends BaseControler {
  private $user_model;
  private $view;

  public function UserControler() {
    $this->view = dirname(__FILE__) . '/../templates/user.php';
    $this->user_model = new User();
  }

  private function Validate($user) {
    if (empty($_POST['name'])) {
      Messages::form_error('name', "Vardas negali būti tuščias.");
    }
    if (!empty($_POST['email'])) {
      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        Messages::form_error('email', "Elektroninis adresas $_POST[email] yra neteisingas.");
    }
    if (!empty($_POST['website'])) {
      if (!filter_var($_POST['website'], FILTER_VALIDATE_URL))
        Messages::form_error('website', "Internetinis adresas $_POST[website] yra neteisingas.");
    }
    if (!empty($_POST['password']) && (!empty($_POST['new_password_1']) || !empty($_POST['new_password_2']))) {
      if (md5($_POST['password']) != $user->password)
        Messages::form_error('password', "Neteisintas senas slaptažodis.");
      else if ($_POST['new_password_1'] != $_POST['new_password_2'])
        Messages::form_error('password', "Įvestas naujas slaptažodis nesutampa.");
      else if (empty($_POST['new_password_1']) || empty($_POST['new_password_2']))
        Messages::form_error('password', "Naujas slaptažodis negali būti tuščias.");
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  public function Edit() {
    $current_user_id = !empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL;
    $id = !empty($_GET['id']) ? $_GET['id'] : (!empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL);

    if (empty($id) || ($current_user_id != $id && !$this->HasPermission()) || !($user = $this->user_model->Get($id)))
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/user/edit.php';

    $edit = array();

    if ($user && $_SERVER['REQUEST_METHOD'] == 'POST') {
      if ($this::Validate($user)) {
        if (!empty($_POST['password']) && !empty($_POST['new_password_1'])) {
          $edit['password'] = md5($_POST['new_password_1']);
        }

        foreach (array('name', 'email', 'telephone1', 'website') as $key) {
          if (isset($_POST[$key]) && $user->{$key} != $_POST[$key])
            $edit[$key] = $_POST[$key];
        }

        if (!empty($_FILES["avatar"]) && $_FILES["avatar"]["error"] != 4) {
          $moved = FALSE;

          if ($_FILES["avatar"]["error"] > 0) {
            //print_r($_FILES["avatar"]);
            die("Error: " . $_FILES["avatar"]["error"]);
          }

          $filename = $id . '-' . $_FILES['avatar']['name'];
          if (function_exists('imagecreatefromstring')) {
            $MAX_WIDTH = 150;
            $MAX_HEIGHT = 150;

            $source = imagecreatefromstring(file_get_contents($_FILES["avatar"]["tmp_name"]));
            list($width, $height) = getimagesize($_FILES["avatar"]["tmp_name"]);

            if (!empty($source) && $width > 0 && $height > 0) {
              $percent = 1;
              if ($width / $height >= $MAX_WIDTH / $MAX_HEIGHT)
                $percent = $MAX_WIDTH / $width;
              else
                $percent = $MAX_HEIGHT / $height;
              $newwidth = $width * $percent;
              $newheight = $height * $percent;

              $thumb = imagecreatetruecolor($MAX_WIDTH, $MAX_HEIGHT);
              imagealphablending($thumb, false);
              imagesavealpha($thumb, true);

              $trans_layer_overlay = imagecolorallocatealpha($thumb, 220, 220, 220, 127);
              imagefill($thumb, 0, 0, $trans_layer_overlay);

              imagecopyresampled($thumb, $source, ($MAX_WIDTH-$newwidth)/2, ($MAX_HEIGHT-$newheight)/2, 0, 0, $newwidth, $newheight, $width, $height);

              $filename = preg_replace('/\..+$/', '.' . 'png', $filename);
              imagepng($thumb, dirname(__FILE__) . "/../uploads/users/$filename");
              unlink($_FILES["avatar"]["tmp_name"]);

              $moved = TRUE;
            }
          }

          if (!$moved)
            move_uploaded_file($_FILES["avatar"]["tmp_name"], dirname(__FILE__) . "/../uploads/users/$filename");

          $edit['avatar'] = $filename;
        }

        if ($this->user_model->Put($id, $edit))
          Messages::set_message('Informacija atnaujinta');

        if (!empty($edit['avatar']) && $user->avatar != $edit['avatar'])
          unlink(dirname(__FILE__) . '/../uploads/users/' . $user->avatar);

        //update session values
        foreach ($edit as $key => $value) {
          $_SESSION['user'][$key] = $value;
          $user->{$key} = $value;
        }

        $this->Transfer();
        //return $this->Index();
      }
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function Index() {
    return $this->View();
  }

  public function View() {

    $id = !empty($_GET['id']) ? $_GET['id'] : (!empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL);
    if (!empty($id) && ($user = $this->user_model->Get($id)) && !empty($user))
      $this->view = dirname(__FILE__) . '/../views/user/view.php';
    else {
      $this->view = NULL;
      Messages::set_message('Vartotojas nerastas');
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function ItemList() {
    $this->view = dirname(__FILE__) . '/../views/user/item-list.php';

    $data = User::getList();
    $results = array('users' => $data['results'], 'totalRows' => $data['totalRows']);

    include dirname(__FILE__) . '/../views/_layout.php';
  }

}
