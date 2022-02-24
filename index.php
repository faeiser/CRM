<?php
// inc´s
require_once  'inc/db.inc.php';
require_once  'inc/funktion.inc.php';
include_once 'inc/head.inc.php';

// pfad
$PHP_SELF = $_SERVER['PHP_SELF'];

echo '<main>';

// funktionen
deleteEntry($db);
changeEntry($db);
makeEntry($db);
showdb($db);

echo '</main>';
include_once 'inc/footer.inc.php';
$db->close();
