#### Listing information in the database

Okay, the last step we're going to do is to create a button that will list **all content** in our table.

To do this, we're going to create a big chunk of code. By now, you should be able to find everything yourself.

First, we're going to add some translation variables for the new text we're going to add.
Open up the **main.php** file in the folder **/language/english** and add this code:

```php
<?php
    define('TT_NAME','Name');
    define('TT_EMAIL','Email');
    define('TT_ADDRESS','Address');
    define('TT_TELEPHONE','Telephone');
?>
```
And finally, ladies and gentlemen, I can present you with the final code for index.php.

We've done 2 big changes: one is that we've created a new button, called listall, that will list all rows in our table once it's pressed.
The other one is an IF condition which will check if the listall button has been pressed.
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