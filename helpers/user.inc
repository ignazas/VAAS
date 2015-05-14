<?php
class UserHelper {
  public static function has_role($role) {
    $roles = !empty($_SESSION['user']['usertype']) ? explode(',', $_SESSION['user']['usertype']) : array('Registered');
    return in_array($role, $roles);
  }

  public static function has_permission($permission = 'administer') {
    $roles = !empty($_SESSION['user']['usertype']) ? explode(',', $_SESSION['user']['usertype']) : array('Registered');

    if (in_array('Super Administrator', $roles))
      return TRUE;

    switch ($permission) {
      case 'administer':
        $result = array_intersect($roles, array('Administrator'));
        return !empty($result);
      case 'day_tag':
        $result = array_intersect($roles, array('Administrator', 'Planner'));
        return !empty($result);
      case 'publish':
        $result = array_intersect($roles, array('Administrator', 'Publisher'));
        return !empty($result);
    }

    return FALSE;
  }

  public static function is_student($user = NULL) {
    $catid = empty($user)
      ? (UserHelper::logged_in() && !empty($_SESSION['user']['catid']) ? $_SESSION['user']['catid'] : 0)
      : $user->catid;
    return in_array($catid, array(29, 19));
  }

  public static function logged_in() {
    UserHelper::init_session();
    return !empty($_SESSION['user']);
  }

  public static function get_id() {
    UserHelper::init_session();
    return empty($_SESSION['user']['id']) ? NULL : $_SESSION['user']['id'];
  }

  public static function log_out() {
    if (UserHelper::logged_in()) {
      require_once dirname(__FILE__) . '/../functions.php';
      log_event($_SESSION['user']['username'], 'Leaves', '');

      session_destroy();
    }
    header("Location: index.php");
    die("Redirecting to: index.php");
  }

  public static function log_in() {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
      require_once dirname(__FILE__) . '/../models/user.inc';
      $user = User::get_by_username($_POST['username']);
      if (!empty($user) && $user->password == md5($_POST['password'])) {
        $_SESSION['user'] = (array)$user;

        //log it
        require_once dirname(__FILE__) . '/../functions.php';
        log_event($user->username, 'Enters', $_SERVER['REMOTE_ADDR']);

        // Redirect the user to the private members-only page.
        $destination = isset($_GET['destination']) ? $_GET['destination'] : 'index.php';
        header("Location: $destination");
        die("Redirecting to: index.php");
      }
      else {
        //log it
        require_once dirname(__FILE__) . '/../functions.php';
        log_event($_POST['username'], 'Knocks', $_SERVER['REMOTE_ADDR']);

        require_once dirname(__FILE__) . '/messages.inc';
        Messages::set_message('Klaida! Prisijungti nepavyko.', 'errors');
      }
    }
  }

  public static function init_session() {
    if (session_id() == '') session_start();
  }

  public static function check_access($redirect=TRUE) {
    UserHelper::init_session();
    if (!UserHelper::logged_in()) {
      if ($redirect === TRUE) {
        header("Location: index.php?action=svecias");
        die("Redirecting to login.php");
      }
      else {
        header("HTTP/1.1 401 Unauthorized");
        die("Access denied");
      }
    }
  }
}
