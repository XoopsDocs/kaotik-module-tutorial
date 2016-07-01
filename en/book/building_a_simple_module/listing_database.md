#### Listing information in the database

Okay, the last step we're going to do is to create a button that will list **all content** in our table.

To do this, we're going to create a big chunk of code. By now, you should be able to find everything yourself.

```php
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
if (isset($_POST['listall'])) {
    echo '<table width="100" border="0">
    <tr>
        <td>Name</td>
        <td>Address</td>
        <td>Telephone</td>
        <td>Email</td>
    </tr>';
    $query = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix(basename(__DIR__)."_myform")";
    while($myrow = $xoopsDB->fetchArray($query) )
    {
        $name       = $myrow['name'];
        $address    = $myrow['address'];
        $telephone  = $myrow['telephone'];
        $email      = $myrow['email'];
    echo '<tr><td>'.$name.'</td><td>'.$address.'</td><td>'.$telephone.'</td><td>'.$email.'</td></tr>';
    }
echo '</table>';
}

if (isset($_POST['submit'])){
    if (empty($_POST['name'])){
        echo 'Please enter a name';
    } else {
        $name=$_POST['name'];
        $address=$_POST['address'];
        $tel=$_POST['tel'];
        $email=$_POST['email'];
        $query = "INSERT INTO ".$xoopsDB->prefix(basename(__DIR__)."_myform")." (name, address, telephone, email) VALUES ('$name', '$address', '$tel', '$email' )";
        $res = $xoopsDB->query($query);
        if(!$res) {
        echo "Error occured: $query";
        } else {
            echo "Data was correctly inserted into DB!";
        }
    }
}
?>
<form name="tutorial_form" method="post" action="index.php">
    <table width="400" border="0">
        <tr>
            <td align="right">Name</td>
            <td><input type="text" name="name"></td>
        </tr><tr>
            <td align="right">Address</td>
            <td><input type="text" name="address"></td>
        </tr><tr>
            <td align="right">Telephone</td>
            <td><input type="text" name="tel"></td>
        </tr><tr>
            <td align="right">Email</td>
            <td><input type="text" name="email"></td>
        </tr><tr>
            <td><input type="submit" name="listall" value="List All"></td>
            <td><input type="submit" name="submit" value="submit"></td>
        </tr>
    </table>
</form>
<?php
require(XOOPS_ROOT_PATH.'/footer.php');
?>
```

We've done 2 big changes: one is that we've created a new button, called listall, that will list all rows in our table once it's pressed.
The other one is an IF condition which will check if the listall button has been pressed.

But, we've almost forgotten about our best practices! We're going to replace our hardcoded text with language constants, so that our module stays translateable.
Open up the **main.php** file in the folder **/language/english** and add this code:

```php
<?php
    define('TT_NAME','Name');
    define('TT_EMAIL','Email');
    define('TT_ADDRESS','Address');
    define('TT_TELEPHONE','Telephone');
?>
```
And finally, ladies and gentlemen, I can present you with the final code for index.php:
```php 
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Let's check if something got submitted.
    if('POST' == Xmf\Request::getMethod()) {
        if(empty(Xmf\Request::getString('name', ''))) {
            echo PP_ENTERNAME;
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
                echo PP_ERROR . $xoopsDB->error;
            } else {
                echo PP_SAVED;
            }
        }
        if(!empty(Xmf\Request::getString('listAll'))) {
            echo '<table width="100" border="0">
                    <tr>
                        <td>'.PP_NAME.'</td>
                        <td>'.PP_ADDRESS.'</td>
                        <td>'.PP_TELEPHONE.'</td>
                        <td>'.PP_EMAIL.'</td>
                    </tr>';
            $query = $xoopsDB->query('SELECT * FROM '. $xoopsDB->prefix(basename(__DIR__)."_myform"));
            while($myRow = $xoopsDB->fetchArray($query)) {
                $name       = $myRow['name'];
                $address    = $myRow['address'];
                $telephone  = $myRow['telephone'];
                $email      = $myRow['email'];
                echo '<tr><td>'.$name.'</td><td>'.$address.'</td><td>'.$telephone.'</td><td>'.$email.'</td></tr>';
            }
            echo '</table>';
        }
    }
    // Load up the XOOPS Form Loader, which gives us access to XoopsForm
    include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    // This might look intimidating, but what we're doing is that we are creating a new form object here called $form,
    // which is based on XoopsThemeForm. We're opening up a new XoopsThemeForm and we give it some parameters.
    // PP_NEWENTRY is used as the name of the form, 'form is the description. $_SERVER['REQUEST_URI'] points the form
    // back to it's own location, so we'll submit to this page. 'post' makes it a POST method.
    $form = new XoopsThemeForm(PP_NEWENTRY, 'form', $_SERVER['REQUEST_URI'], 'post');
    // This adds a text input, with the PP_NAME, description 'Name', minimum length of 15 and maximum length of 75. True means that it's required.
    $form->addElement(new XoopsFormText(PP_NAME, 'name', 15, 50), false);
    $form->addElement(new XoopsFormText(PP_ADDRESS, 'address', 15, 50), false);
    // Telephone is an optional field.
    $form->addElement(new XoopsFormText(PP_TELEPHONE, 'telephone', 15, 50), false);
    $form->addElement(new XoopsFormText(PP_EMAIL, 'email', 15, 50), false);
    $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    $form->addElement(new XoopsFormButton('', 'listAll', "List all", 'submit'), false);
    // Once we're done, we're going to render the form
    $form->render();
    // And finally, we're going to display it.
    echo $form->display();

    // This file contains the footer, which contains scripts and closes our layout.
    require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```

Congratulations, that's the end of this tutorial! I hope you've learned quite a bit and are ready to get started on building your first awesome module!
Good luck!