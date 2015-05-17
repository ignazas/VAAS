<?php
require_once dirname(__FILE__) . '/../models/practice.inc';
$data = Practice::getList();
$result = array();
foreach ($data['results'] as $record) {
  $result[$record->id] = array('id' => $record->id, 'name' => $record->phase_no . (empty($record->no) ? NULL : ".$record->no") . " $record->title");
}

echo json_encode($result);
