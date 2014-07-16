<?php
require_once dirname(__FILE__) . '/../models/aircraft.inc';
$data = Aircraft::getList();
echo json_encode($data['results']);
