<?php

// put full path to Smarty.class.php
require('smarty/lib/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('app/views');
$smarty->setCompileDir('smarty/templates_c');
$smarty->setCacheDir('smarty/cache');
$smarty->setConfigDir('smarty/configs');

$smarty->assign('name', 'Ned');

?>

<?php

    switch ($_GET['action']) {
        case 'index':
            $smarty->display('events/index.tpl');
            break;
        case 'new':
            break;
        case 'create':
            break;
        case 'edit':
            break;
        case 'update':
            break;
        case 'delete':
            break;
    }
?>