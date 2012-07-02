<?php


define(ROOT_DIR, "../eventpublish/");

require_once(ROOT_DIR . 'libs/Smarty/libs/Smarty.class.php');
require_once(ROOT_DIR . 'libs/System/Load.php');
require_once(ROOT_DIR . 'libs/Data/Load.php');


define (EP_PAGE_TITLE, "Event Publish Installer");
define(ACCOUNT_ADMIN, 1);
define(ACCOUNT_USER, 2);

$template_dir = "templates/";

$Smarty = new Smarty();
$Smarty->template_dir = $template_dir;
$Smarty->assign('template_dir', $template_dir);

$Smarty->assign('page_title', EP_PAGE_TITLE);

?>