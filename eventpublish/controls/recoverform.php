<?php

define(ROOT_DIR, "../");

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once(ROOT_DIR . 'main.' . PHP_EXT);

$mdb2 = MDB2::factory($dsn, $options);

/************* extract settings ***************************/
$SettingsData = new SettingsData($mdb2);
$Settings = $SettingsData->load();

$setting_data = $Settings->getAll();

$template = "new";

/**********************************************************/

// template directory:
$template_dir = ROOT_DIR . "templates/" . $template . "/controls/";

$Smarty = new Smarty();
$Smarty->template_dir = $template_dir;
$Smarty->assign('template_dir', $template_dir);

$Smarty->assign('show_default_message', 1);
$Smarty->assign('show_recovery_error', 0);
$Smarty->assign('page_title', EP_PAGE_TITLE);
$Smarty->display('page_header.tpl');
$Smarty->display('password_recovery.tpl');
$Smarty->display('page_footer.tpl');

?>
