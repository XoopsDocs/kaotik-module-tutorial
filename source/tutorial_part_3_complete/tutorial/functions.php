<?php

require_once XOOPS_ROOT_PATH . '/class/template.php';
if (!isset($xoopsTpl)) {
$xoopsTpl = new XoopsTpl();
}
$xoopsTpl->xoops_setCaching(0);

function processFormData($arg)
{
    // do some stuff based on $arg like query data from a database and
    // put it into a variable like $newContent
    $newContent = addClient($arg);
    
    // Instantiate the xajaxResponse object
    $objResponse = new xajaxResponse();
    
    // add a command to the response to assign the innerHTML attribute of
    // the element with id="SomeElementId" to whatever the new content is
    $objResponse->assign("thisID","innerHTML", $newContent);
    
    //return the  xajaxResponse object
    return $objResponse;
}

function showForm()
{
global $xoopsTpl;

$text = $xoopsTpl->fetch('db:tut_form.html');

$objResponse = new xajaxResponse();
$objResponse->assign("formDiv","innerHTML",$text);
return $objResponse;
}

function addClient($data)
{
global $xoopsDB;
$myts = myTextSanitizer::getInstance();
$name=$myts->addslashes($data['name']);
$address=$myts->addslashes($data['address']);
$tel=$myts->addslashes($data['tel']);
$email=$myts->addslashes($data['email']);
$query = "Insert into ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) values ('$name', '$address', '$tel', '$email' )";
	$res=$xoopsDB->query($query);
	if(!$res) {
	$msg="error: $query";
	} else {
	$msg="Data was correctly inserted into DB!";
	}
	return $msg;
}

function listClients(){
global $xoopsTpl;

$clients=clientLoader();
$xoopsTpl->assign('clients', $clients);

$text = $xoopsTpl->fetch('db:tut_client_list.html');

$objResponse = new xajaxResponse();
$objResponse->assign("clientListDiv","innerHTML",$text);
return $objResponse;

}


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

?>