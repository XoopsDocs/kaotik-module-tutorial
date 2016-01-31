<?php
// Tutorial                    										
// Created by KaotiK												
require('../../mainfile.php');
$xoopsOption['template_main'] = 'tut_main.html';
require(XOOPS_ROOT_PATH.'/header.php');

if (isset($_GET['addnew'])){
$xoopsTpl->assign('addnew', 1);
}


if (isset($_POST['submit'])){
if (empty($_POST['name'])){
echo 'please fill in a name';
} else {
$myts = myTextSanitizer::getInstance();
$name=$myts->addslashes($_POST['name']);
$address=$myts->addslashes($_POST['address']);
$tel=$myts->addslashes($_POST['tel']);
$email=$myts->addslashes($_POST['email']);
$query = "Insert into ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) values ('$name', '$address', '$tel', '$email' )";
	$res=$xoopsDB->query($query);
	if(!$res) {
	$xoopsTpl->assign('msg', "error: $query");
	} else {
	$xoopsTpl->assign('msg', "Data was correctly inserted into DB!");
	}
}
}

$clientdata=clientLoader();
$xoopsTpl->assign('client', $clientdata);


function clientLoader(){
global $xoopsDB;
$client=array();
$q=1;
$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('tutorial_myform'));
while($myrow = $xoopsDB->fetchArray($query) )
{
$client[$q]['name'] = $myrow['name'];
$client[$q]['address'] = $myrow['address'];
$client[$q]['telephone'] = $myrow['telephone'];
$client[$q]['email'] = $myrow['email'];
$q++;
}
return $client;
}

require(XOOPS_ROOT_PATH.'/footer.php');
?>