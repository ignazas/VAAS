<?php
require_once dirname(__FILE__) . '/../models/service.inc';
$data = Service::getList();
echo json_encode($data['results']);
