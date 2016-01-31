<?php
// Tutorial                    										
// Created by KaotiK												
require('../../mainfile.php');

require_once(XOOPS_ROOT_PATH.'/modules/tutorial/functions.php');
require_once(XOOPS_ROOT_PATH.'/modules/tutorial/class/xajax/xajax_core/xajax.inc.php');

$xajax = new xajax();
$xajax->registerFunction("processFormData");
$xajax->registerFunction("showForm");
$xajax->registerFunction("listClients");
//$xajax->setFlag("debug", true);
$xajax->processRequest();

$Xjavapath=XOOPS_URL.'/modules/tutorial/class/xajax';
$xajaxjava=$xajax->getJavascript($Xjavapath);

$xoopsOption['template_main'] = 'tut_main.html';
require(XOOPS_ROOT_PATH.'/header.php');
$xoopsTpl->assign('xajaxjava', $xajaxjava);


require(XOOPS_ROOT_PATH.'/footer.php');
?>