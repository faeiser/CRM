<?php
//Fehlermeldungen aus
error_reporting(0);
//Fehlermeldungen an
// error_reporting(E_ALL);
$db = new mysqli('localhost', 'root', '', 'customermanagement');
$db->set_charset('utf8');
//Fehlercode ausgeben ohne Pfade
// print_r($db->connect_error);
//Fehlercode verschönern
if ($db->connect_errno) {
    die('Sorry - gerade gibt es ein Problem');
}
