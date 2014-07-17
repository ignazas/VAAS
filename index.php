<?php
require_once dirname(__FILE__) . '/helpers/user.inc';
require "config.php";
require "functions.php";
require "helpers/route.inc";

if (UserHelper::logged_in()) {
    require "models/user.inc";
    $user_model = new User();
    $user_model->Put($_SESSION['user']['id'], array('lastvisitDate' => date('Y-m-d H:i:s')));

    $action = isset( $_GET['action'] ) ? $_GET['action'] : "dashboard";
    $view = isset($_GET['view']) ? $_GET['view'] : 'Index';
    if (method_exists('Index', $action))
      Index::$action();
    else if (($controller = load_controller($action)) && method_exists($controller, $view))
      $controller->{$view}();
    else
      die('Unknown action');
}
else {
  if (isset($_GET['action']) && $_GET['action'] == 'on')
    Index::on();
  else
    Index::svecias();
}
