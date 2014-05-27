<?php

require "config.php";
require "functions.php";
require "helpers/route.inc";

$con=DB::connect();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
if (method_exists('Index', $action))
  Index::$action();
else if ($controller = load_controller($action))
  $controller->Run();
else
  Index::home();
