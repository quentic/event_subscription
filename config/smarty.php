<?php

// put full path to Smarty.class.php
require('../../smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->setCompileDir('../../smarty/templates_c');
$smarty->setCacheDir('../../smarty/cache');
$smarty->setConfigDir('../../smarty/configs');

?>