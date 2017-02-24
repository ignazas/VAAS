<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/user.inc';
require_once dirname(__FILE__) . '/../models/user_group.inc';
require_once dirname(__FILE__) . '/../models/category.inc';


class UserControler extends BaseControler {
  private $user_model;
  private $view;

  public function UserControler() {
    $this->view = dirname(__FILE__) . '/../templates/user.php';
    $this->user_model = new User();
  }

  private function Validate($user) {
    $current_user_id = !empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL;
    $id = !empty($_GET['id']) ? $_GET['id'] : (!empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL);

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
    if (($this->HasPermission() || (!empty($id) && $current_user_id == $id)) && (!empty($_POST['new_password_1']) || !empty($_POST['new_password_2']))) {
      if ($_POST['new_password_1'] != $_POST['new_password_2'])
        Messages::form_error('password', "Įvestas naujas slaptažodis nesutampa.");
      else if (empty($_POST['new_password_1']) || empty($_POST['new_password_2']))
        Messages::form_error('password', "Naujas slaptažodis negali būti tuščias.");
    }

    if (isset($_POST['discount'])) {
        if (!is_numeric($_POST['discount'])) {
            Messages::form_error('discount', "Antkainis turi būti skaitinė.");
        }
        else if ((int)$_POST['discount'] < 0 || (int)$_POST['discount'] > 100) {
            Messages::form_error('discount', "Antkainis turi būti tarp 0% ir 100%.");
        }
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  private function SaveAvatar() {
    if (!empty($_FILES["avatar"]) && $_FILES["avatar"]["error"] != 4) {
      $moved = FALSE;

      if ($_FILES["avatar"]["error"] > 0) {
        //print_r($_FILES["avatar"]);
        die("Error: " . $_FILES["avatar"]["error"]);
      }
      
      $id = !empty($_GET['id']) ? $_GET['id'] : (!empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL);
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

      return $filename;
    }

    return FALSE;
  }

  public function NewItem() {
    if (!$this->HasPermission())
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/user/edit.php';

    $current_user_id = !empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL;

    $edit = array();
    $user = new User($_POST);
    if (!isset($user->discount))
      $user->discount = 0;
    if (!isset($user->usertype))
      $user->usertype = 'Registered';
    if (!isset($user->birthdate))
      $user->birthdate = '0000-00-00';

    if ($user && $_SERVER['REQUEST_METHOD'] == 'POST') {
      if (empty($_POST['new_password_1']) || empty($_POST['new_password_2']) || $_POST['new_password_1'] != $_POST['new_password_2'])
        Messages::form_error('new_password_1', "Slaptažodis negali būti tuščias ir turi sutapti.");

      if ($this::Validate($user)) {
        $password = $_POST['new_password_1'];
        $user->password = md5($password);

        if (($filename = $this::SaveAvatar()) !== FALSE)
          $user->avatar = $filename;

        if ($user->insert()) {
          require_once dirname(__FILE__) . '/../models/finance.inc';
          $finance = new Finance();
          $finance->contact_id = $user->contact_id;
          $finance->insert();
          Messages::set_message('Vartotojas sukurtas');

          $url = '/index.php';
          if (!empty($_SERVER['HTTP_HOST'])) {
            $base = 'http://' . $_SERVER['HTTP_HOST'];
            if (!empty($url) && $url[0] == '?')
              $base .= $_SERVER['PHP_SELF'];
            else
              $base .= dirname($_SERVER['PHP_SELF']);
            $url = $base . $url;
          }
          send_mail($user->email, 'Jūs esate pridėti į VAAS sistemą', "Jūs esate pridėti į VAAS sistemą<br /><br />Prie sistemą galite prisijungi šiuo adresu: $url<br /><br />Vartotojo vardas: $user->username<br />Slaptažodis: $password");

          $this->Transfer(NULL, 'Index', array('id' => $user->id));
        }
        else {
          Messages::set_message('Vartotojas nesukurtas', 'errors');
        }
      }
    }

    if (UserHelper::is_student($user))
      $instructors = User::getList(1000000, 'u.name', 'u.instructor=1');

    $categories = Category::getList(1000000, 'name');

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function Edit() {
    $current_user_id = !empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL;
    $id = !empty($_GET['id']) ? $_GET['id'] : (!empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL);

    if (empty($id) || ($current_user_id != $id && !$this->HasPermission()) || !($user = $this->user_model->Get($id)))
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/user/edit.php';

    $edit = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $roles = '';
      foreach ($_POST as $key => $value) {
        if (strpos($key, 'usertype|') === 0 && !empty($value)) {
          $v = explode('|', $key);
          if (!empty($v[1]))
            $roles .= (empty($roles) ? NULL : ',') . str_replace('_', ' ', $v[1]);
        }
      }
      $edit['usertype'] = $roles;
      $edit['instructor'] = empty($_POST['instructor']) ? 0 : 1;

      if ($this::Validate($user)) {
        if (!empty($_POST['new_password_1'])) {
          $edit['password'] = md5($_POST['new_password_1']);
	        Messages::set_message("Slaptažodis vartotojui $user->name pakeistas.");
        }

        foreach (array('name', 'username', 'email', 'telephone1', 'website', 'discount', 'licenseNo', 'licenseValidTill', 'healthNo', 'healthValidTill', 'instructor_id', 'catid') as $key) {
          if (isset($_POST[$key]) && $user->{$key} != $_POST[$key])
            $edit[$key] = $_POST[$key];
        }

        if (($filename = $this::SaveAvatar()) !== FALSE)
          $edit['avatar'] = $filename;

        if ($this->user_model->Put($id, $edit))
          Messages::set_message('Informacija atnaujinta');

        if (!empty($edit['avatar']) && $user->avatar != $edit['avatar'])
          unlink(dirname(__FILE__) . '/../uploads/users/' . $user->avatar);

        //update session values
        if ($current_user_id == $id) {
          foreach ($edit as $key => $value) {
            $_SESSION['user'][$key] = $value;
            $user->{$key} = $value;
          }
        }

        $this->Transfer(NULL, 'Index', array('id' => $id));
        //return $this->Index();
      }
    }
    else {
      foreach (explode(',', $user->usertype) as $usertype) {
        if (!empty($usertype))
          $edit['usertype|' . str_replace(' ', '_', $usertype)] = 1;
      }
    }

    if (UserHelper::is_student($user))
      $instructors = User::getList(1000000, 'u.name', 'u.instructor=1');

    $categories = Category::getList(1000000, 'name');

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function Index() {
    return $this->View();
  }

  public function View() {

    $id = !empty($_GET['id']) ? $_GET['id'] : (!empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL);
    if (!empty($id) && ($user = $this->user_model->Get($id)) && !empty($user)) {
      if (!empty($user->instructor_id))
        $user->practice_instructor = User::Get($user->instructor_id);

      $this->view = dirname(__FILE__) . '/../views/user/view.php';
    }
    else {
      $this->view = NULL;
      Messages::set_message('Vartotojas nerastas');
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function ItemList() {
    $this->view = dirname(__FILE__) . '/../views/user/item-list.php';

    $filters = array();
    if (!empty($_GET['search'])) {
      $escaped = DB::escape('%' . $_GET['search'] . '%');
      $filters[] = "(u.name LIKE $escaped OR u.username LIKE $escaped OR u.email LIKE $escaped)";
    }
    if (!empty($_GET['group']) && is_numeric($_GET['group']))
      $filters[] = 'ud.catid=' . (int)$_GET['group'];
    if (isset($_GET['instructor']) && is_numeric($_GET['instructor']))
      $filters[] = 'u.instructor=' . (int)$_GET['instructor'];

    $results = array(
      'users' => User::getList(1000000, 'u.name', implode(' AND ', $filters)),
      'groups' => UserGroup::getList(),
    );

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function Delete() {
    if (!$this->HasPermission())
      $this->Transfer();

    $id = !empty($_GET['id']) ? $_GET['id'] : NULL;
    if (empty($id) || !($user = $this->user_model->Get($id))) {
      Messages::set_message("Vartotojas nerastas.", 'errors');
    }
    else {
      //log it
      log_event("Admin", "UserDeleted", 'user id: ' . $user->id);

      $user->delete();
      Messages::set_message("Vartotojas $user->name pašalintas.");
    }
	  $this->Transfer(NULL, 'ItemList');
  }
}
