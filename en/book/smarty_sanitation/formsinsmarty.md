#### Forms in Smarty
Let's now create a new form to insert new clients in our database. We're basicly going to use the same code for this that we used in chapter 1.
There are a couple of ways of doing this with Smarty templates, so I'm going to show the one with the most possibilities, however the price for this is that it might not be the easiest one.
Open up **xoops_version.php** and add the new code:

```php
<?php
// Tutorial Module 
// Created by kaotik
$modversion['name'] = "Tutorial";
$modversion['version'] = 2.00;
$modversion['description'] = "This is a tutorial module to teach how to build a simple module";
$modversion['author'] = "KaotiK";
$modversion['credits'] = "KaotiK";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/tutorial.png";
$modversion['dirname'] = "tutorial";
// Admin
$modversion['hasAdmin'] = 0;
// Menu
$modversion['hasMain'] = 1;
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "tutorial_myform";
// Templates
$modversion['templates'][1]['file'] = 'tut_form.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'tut_main.html';
$modversion['templates'][2]['description'] = '';
?>
```
You should notice 2 things here, one of them being that we added a new template and the other is that our main template is now number two. The reason for this is that I will be including tut_form.html inside tut_main.html.
In order to include a Smarty template inside another, you first need to declare the template which is to be included.

Now, let's go to the **templates** folder and let's create the new template **tut_form.html**. 
Since we've updated the templates, we'll also need to update the tutorial module in the Module Administration of our XOOPS installation.

Open up **tut_form.html** and add this code:

```html
<form name="tutorial_form" method="post" action="index.php">
    <table width="400" border="0">
        <tr>
            <td align="right"><{$smarty.const.TT_NAME}></td>
            <td><input type="text" name="name"></td>
        </tr><tr>
            <td align="right"><{$smarty.const.TT_ADDRESS}></td>
            <td><input type="text" name="address"></td>
        </tr><tr>
            <td align="right"><{$smarty.const.TT_TELEPHONE}></td>
            <td><input type="text" name="tel"></td>
        </tr><tr>
            <td align="right"><{$smarty.const.TT_EMAIL}></td>
            <td><input type="text" name="email"></td>
        </tr><tr>
            <td><input type="submit" name="listall" value="List All"></td>
            <td><input type="submit" name="submit" value="submit"></td>
        </tr>
    </table>
</form>
```
Next, we'll need to open up **tut_main.html** and add this single line of code at the very top:

```php
<{include file="db:tut_form.html"}>
```
If you open up our tutorial module from the main menu, you should see a form at the top of our page. Let's take this a step further, shall we, and replace **tut_main.html** with this code:

```php
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><a href="index.php?addnew=1">Add new client</a></td>
    </tr>
</table>
    <{if $addnew==1}>
        <{include file="db:tut_form.html"}>
    <{/if}>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td><{$smarty.const.TT_NAME}></td>
            <td><{$smarty.const.TT_ADDRESS}></td>
            <td><{$smarty.const.TT_TELEPHONE}></td>
            <td><{$smarty.const.TT_EMAIL}></td>
        </tr>
        <{foreach item=cli from=$client}>
        <tr>
            <td><{$cli.name}></td>
            <td><{$cli.address}></td>
            <td><{$cli.telephone}></td>
            <td><{$cli.email}></td>
        </tr>
        <{/foreach}>
    </table>
?>
```
Now we should have a new link called **Add new client**, and when this link is clicked, the form will display. Now open up **index.php** and replace all the code with this:

```php
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
$xoopsOption['template_main'] = 'tut_main.html';
require(XOOPS_ROOT_PATH.'/header.php'); 
if (isset($_GET['addnew'])){
    $xoopsTpl->assign('addnew', 1);
}
$clientdata = clientLoader();
$xoopsTpl->assign('client', $clientdata);
function clientLoader(){
    global $xoopsDB;
    $client = array();
    $q = 1;
    $query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('tutorial_myform'));
    while($myrow = $xoopsDB->fetchArray($query) )
    {
        $client[$q]['name']         = $myrow['name'];
        $client[$q]['address']      = $myrow['address'];
        $client[$q]['telephone']    = $myrow['telephone'];
        $client[$q]['email']        = $myrow['email'];
        $q++;
    }
    return $client;
}
require(XOOPS_ROOT_PATH.'/footer.php');
?>
```
I have added an if condition that check if the link was pressed, and it if was the Smarty variable addnew is set to 1, which will make the template **tut_form.html** display.
Now, let's properly process the info from the form and insert it into the database. For this, we're going to re-use the code from chapter 1.

Open up **index.php** and replace all code with this:

```php
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
        $xoopsTpl->assign('msg', "Please fill in a name");
    } else {
        $name       = $_POST['name'];
        $address    = $_POST['address'];
        $tel        = $_POST['tel'];
        $email      = $_POST['email'];
        $query      = "INSERT INTO ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) VALUES ('$name', '$address', '$tel', '$email' )";
        $res = $xoopsDB->query($query);
        if(!$res) {
            $xoopsTpl->assign('msg', "Error occured: $query");
        } else {
            $xoopsTpl->assign('msg', "Data was correctly inserted into the database!");
        }
    }
}
$clientdata = clientLoader();
$xoopsTpl->assign('client', $clientdata);
function clientLoader(){
    global $xoopsDB;
    $client = array();
    $q = 1;
    $query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('tutorial_myform'));
    while($myrow = $xoopsDB->fetchArray($query) )
    {
        $client[$q]['name']         = $myrow['name'];
        $client[$q]['address']      = $myrow['address'];
        $client[$q]['telephone']    = $myrow['telephone'];
        $client[$q]['email']        = $myrow['email'];
        $q++;
    }
    return $client;
}
require(XOOPS_ROOT_PATH.'/footer.php');

```

Let's continue on and fix more issue with our code!
