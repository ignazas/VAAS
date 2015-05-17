<?php
require_once dirname(__FILE__) . '/../models/user.inc';
$users = User::getList();
$result = array();
foreach ($users['results'] as $user) {
  $result[$user->id] = array('id' => $user->id, 'name' => $user->name, 'discount' => $user->discount, 'instructor' => $user->instructor);
}

echo json_encode($result);
