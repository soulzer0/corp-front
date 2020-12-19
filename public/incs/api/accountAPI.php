<?php
require_once('../geral.php');
$received_data = json_decode(file_get_contents("php://input"));
print_r($received_data);