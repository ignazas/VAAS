<?php
require_once dirname(__FILE__) . '/../models/aircraft.inc';
$data = Aircraft::getList();
foreach ($data['results'] as &$aircraft) {
  $aircraft->name = $aircraft->name . (!empty($aircraft->reg_num) ? ' (' . $aircraft->reg_num . ')' : NULL);
}
echo json_encode($data['results']);
