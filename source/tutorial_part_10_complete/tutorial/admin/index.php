<?php

require_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/template.php';
if (!isset($xoopsTpl)) {$xoopsTpl = new XoopsTpl();}
$xoopsTpl->xoops_setCaching(0);

xoops_cp_header();

$xoopsTpl->display('db:tut_admin_main.html');

xoops_cp_footer();


?>