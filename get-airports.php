<?php

require_once 'lib/Database.php';

$request = "SELECT a.name airport_name, a.code, c.name country_name FROM airport a INNER JOIN country c ON c.code = a.country_code
;";

$airports = Database::getInstance()->query($request);
$airportsList = json_encode($airports);

echo $airportsList;