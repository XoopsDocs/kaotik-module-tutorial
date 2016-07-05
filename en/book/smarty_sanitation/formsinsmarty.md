#### Forms in Smarty
In order to add new information to our database, we'll need to add a database. We're basicly going to use the same code for this that we previously used - what isn't broken doesn't need fixing - but we'll lightly tweak it.

Let's get started and open up **xoops_version.php** and add the new code at the bottom:

```php
<?php
    // People Module, by KaotiK and kevinpetit

    // The line below will make sure that our module is cloneable. If you change the name of the folder, it will still work.
    $modversion['name'] = ucfirst(basename(__DIR__));
    // The version of our module.
    $modversion['version'] = 1.00;
    // A description of our first module!
    $modversion['description'] = "Our very first module that contains a people database!";
    // The authors of the module. You may put your own name here :)
    $modversion['author'] = "KaotiK & kevinpetit";
    // The credits of the module. Always credit everyone ;).
    $modversion['credits'] = "KaotiK & kevinpetit";
    // A link to the help page. We don't have one.
    $modversion['help'] = "";
    // The license of our module. This **SHOULD ALWAYS BE GNU GPL**.
    $modversion['license'] = "GNU GPL 2 or later";
    // Wether or not our module is an official XOOPS module. It is not.
    $modversion['official'] = 0;
    // The image that will be shown in the XOOPS admin.
    $modversion['image'] = "images/people.png";
    // This makes sure that our module still works if the name of our module is changed.
    $modversion['dirname'] = basename(__DIR__);
    // If we want to have a backend to our module, we can enable this here.
    $modversion['hasAdmin'] = 0;
    // If we want our module to show up in the main menu, we set this to 1.
    $modversion['hasMain'] = 1;

    // Database information
    // This tells XOOPS to execute this .SQL file for MySQL databases
    $modversion['sqlfile']['mysql'] = "sql/mysql.sql";
    // This tells XOOPS how many and which tables we want to use.
    $modversion['tables'][0] = basename(__DIR__)."_myform";

    // Templates
    $modversion['templates'][1]['file'] = 'people_form.html';
    $modversion['templates'][1]['description'] = '';
    $modversion['templates'][2]['file'] = 'people_main.html';
    $modversion['templates'][2]['description'] = '';
?>
```
You should notice 2 things here, one of them being that we added a new template and the other one is that our main template is now number two. The reason for this is that I will be including **people_form.html** inside **people_main.html**.
In order to include a Smarty template inside another, you first need to declare the template which is to be included.
In other words you can't include something what Smarty doesn't already know about.

Now, let's go to the **templates** folder and let's create the new template **people_form.html**. 
Since we've updated the templates, we'll also need to update the tutorial module in the Module Administration of our XOOPS installation.

Open up **people_form.html** and add this code:

```html
<form name="tutorial_form" method="post" action="index.php">
    <table width="400" border="0">
        <tr>
            <td align="right"><{$smarty.const.PP_NAME}></td>
            <td><input type="text" name="name"></td>
        </tr><tr>
            <td align="right"><{$smarty.const.PP_ADDRESS}></td>
            <td><input type="text" name="address"></td>
        </tr><tr>
            <td align="right"><{$smarty.const.PP_TELEPHONE}></td>
            <td><input type="text" name="tel"></td>
        </tr><tr>
            <td align="right"><{$smarty.const.PP_EMAIL}></td>
            <td><input type="text" name="email"></td>
        </tr><tr>
            <td><input type="submit" name="listAll" value="List All"></td>
            <td><input type="submit" name="submit" value="submit"></td>
        </tr>
    </table>
</form>
```
Next, we'll need to open up **people_main.html** and add this single line of code at the very top:

```php
<{include file="db:people_form.html"}>
```
If you open up our tutorial module from the main menu, you should see a form at the top of our page. Let's take this a step further, shall we, and replace **people_main.html** with this code:

```php
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><a href="index.php?addnew=1">Add new person</a></td>
    </tr>
</table>
<{if $addNew==1}>
    <{include file="db:people_form.html"}>
<{/if}>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><{$smarty.const.PP_NAME}></td>
        <td><{$smarty.const.PP_ADDRESS}></td>
        <td><{$smarty.const.PP_TELEPHONE}></td>
        <td><{$smarty.const.PP_EMAIL}></td>
    </tr>
    <{foreach item = person from = $persons}>
    <tr>
        <td><{$person.name}></td>
        <td><{$person.address}></td>
        <td><{$person.telephone}></td>
        <td><{$person.email}></td>
    </tr>
    <{/foreach}>
</table>
?>
```
Now we should have a new link called **Add new client**, and when this link is clicked, the form should display. Now open up **index.php** and replace all the code with this so this will actually work:

```php
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // Specify what template to use
    $xoopsOption['template_main'] = 'people_main.html';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Let's check if we should load the new people form or not..
    if((Xmf\Request::getString('addNew')) == true) {
        // Assign true to addNew
        $xoopsTpl->assign('addNew', 1);
    }

    $personData = personLoader();
    $xoopsTpl->assign('person', $personData);
    function personLoader() {
        // Get the global xoopsDB
        global $xoopsDB;
        // Create a new empty array client
        $client = array();
        // A nice counter set to 1
        $i = 1;
        // Let's create our query.
        $query = $xoopsDB->query('SELECT * FROM '. $xoopsDB->prefix(basename(__DIR__).'_myform'));
        // Perform our query and loop through it
        while($myRow = $xoopsDB->fetchArray($query)) {
            // First run, this will be $client[1]['name'], next one $client[2]['name'], etc.
            $client[$i]['name']         =   $myRow['name'];
            $client[$i]['address']      =   $myRow['address'];
            $client[$i]['telephone']    =   $myRow['telephone'];
            $client[$i]['email']        =   $myRow['email'];
            // Let's add one to the counter
            $i++;
        }
        // Let's return our array.
        return $client;
    }
    // This file contains the footer, which contains scripts and closes our layout.
    require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```
What we've done now is adding a condition that checks wether or not our link was pressed. If it is pressed, the Smarty variable **addnew** is set to 1. This in turn will make the template **people_form.html** display.
Now, let's properly process the info from the form and insert it into the database. For this, we're going to re-use the code from chapter 1.

Open up **index.php** and replace all code with this:

```php
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // Specify what template to use
    $xoopsOption['template_main'] = 'people_main.html';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Check if we got any POST data
    if('POST' == Xmf\Request::getMethod()) {
        // If the name isn't filled in...
        if(empty(Xmf\Request::getString('name', ''))) {
            // Display an error.
            $xoopsTpl->assign('msg', PP_ENTERNAME);
        } else {
            //  You should NEVER trust anything that your users post - always first check the input.
            $name       =   $xoopsDB->escape(Xmf\Request::getString('name', ''));
            $address    =   $xoopsDB->escape(Xmf\Request::getString('address', ''));
            $tel        =   $xoopsDB->escape(Xmf\Request::getString('tel', ''));
            $email      =   $xoopsDB->escape(Xmf\Request::getString('email', ''));
            // All values are done, let's prepare our SQL-query to store this information
            $query      =   "INSERT INTO ".$xoopsDB->prefix(basename(__DIR__)."_myform")." (name, address, telephone, email) VALUES ('$name', '$address', '$tel', '$email' )";
            // Let's perform the query
            $res        =   $xoopsDB->query($query);
            if (!$res) {
                $xoopsTpl->assign('msg', PP_ERROR . $xoopsDB->error);
            } else {
                $xoopsTpl->assign('msg', PP_SAVED);
            }
        }
    } else {
        // Let's check if we should load the new people form or not..
        if((Xmf\Request::getString('addnew')) == true) {
            // Assign true to addNew
            $xoopsTpl->assign('addNew', 1);
        }
    }
    $personData = personLoader();
    $xoopsTpl->assign('persons', $personData);
    function personLoader() {
        // Get the global xoopsDB
        global $xoopsDB;
        // Create a new empty array client
        $client = array();
        // A nice counter set to 1
        $i = 1;
        // Let's create our query.
        $query = $xoopsDB->query('SELECT * FROM '. $xoopsDB->prefix(basename(__DIR__).'_myform'));
        // Perform our query and loop through it
        while($myRow = $xoopsDB->fetchArray($query)) {
            // First run, this will be $client[1]['name'], next one $client[2]['name'], etc.
            $client[$i]['name']         =   $myRow['name'];
            $client[$i]['address']      =   $myRow['address'];
            $client[$i]['telephone']    =   $myRow['telephone'];
            $client[$i]['email']        =   $myRow['email'];
            // Let's add one to the counter
            $i++;
        }
        // Let's return our array.
        return $client;
    }
    // This file contains the footer, which contains scripts and closes our layout.
    require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```

Let's continue on and refine our code a bit more!
