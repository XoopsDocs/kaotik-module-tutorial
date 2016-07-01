#### Saving to the database

Finally, we have arrived at storing our information! We will now insert the form data that we enter into our database table. I hope you're ready!
Before we actually store the data, we're going to have a talk about safety on the internet - no, not the dull kind.
If we would simply add things to the website, without checking them, it would be very insecure as our user might be up to no good!
What if he tries to do a SQL-injection attack (which allows them to see ALL content in the database, or even worse, can delete everything).

The way to avoid this is text-sanitation. This way, we're checking everything that our user is doing and we're preventing them to write code that can be executed.
Should our user write code, it would be escaped and because of that, it wouldn't be executable anymore and it can't harm us.
In the next example, text sanitation is already included. More information about this subject is available in another tutorial.

Thanks to XOOPS, text sanitation is very easy.

First, let's add some new translations. Add these lines to the bottom of **english\main.php**:
```php 
    define('PP_ENTERNAME', 'Please enter a name!');
    define('PP_ERROR', 'We\'ve encountered an error:');
    define('PP_SAVED', 'The information has been stored!');
``` 
And now we can finalize our file **index.php**:
```php 
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Let's check if something got submitted.
    if('POST' == XoopsRequest::getMethod()) {
        if(empty(XoopsRequest::getString('name', ''))) {
            echo PP_ENTERNAME;
        } else {
            //  You should NEVER trust anything that your users post - always first check the input.
            $name       =   $xoopsDB->escape(XoopsRequest::getString('name'));
            $address    =   $xoopsDB->escape(XoopsRequest::getString('address', ''));
            $tel        =   $xoopsDB->escape(XoopsRequest::getString('tel', ''));
            $email      =   $xoopsDB->escape(XoopsRequest::getString('email', ''));
            // All values are done, let's prepare our SQL-query to store this information
            $query      =   "INSERT INTO ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) VALUES ('$name', '$address', '$tel', '$email' )";
            // Let's perform the query
            $res        =   $xoopsDB->query($query);
            if (!$res) {
                echo PP_ERROR . $xoopsDB->error;
            } else {
                echo PP_SAVED;
            }
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
    $form->addElement(new XoopsFormText(PP_NAME, 'name', 15, 50), true);
    $form->addElement(new XoopsFormText(PP_ADDRESS, 'name', 15, 50), true);
    // Telephone is an optional field.
    $form->addElement(new XoopsFormText(PP_TELEPHONE, 'name', 15, 50), false);
    $form->addElement(new XoopsFormText(PP_EMAIL, 'name', 15, 50), true);
    $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    // Once we're done, we're going to render the form
    $form->render();
    // And finally, we're going to display it.
    echo $form->display();

    // This file contains the footer, which contains scripts and closes our layout.
    require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```

The first 4 lines of new code set up variables which contain the form information. Upon sending a form, all information is stored in the XoopsRequest object.
The next line, **$query**, sets up the query that will be used to actually insert our data.
The line **$res** then performs this query, and with the next line we check if the data was inserted or not.

If everything went good, we should see **Data was correctly inserted into the database!". If something went wrong, we'll see the error.

Next, we'll list everything in our database!