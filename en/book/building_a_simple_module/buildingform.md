#### Building a form

We've gotten quite far, so let's take the last hurdle and finish our first module! In order to store things in our database, we use a form.
Let's get to work and start building this form.

Before we can do that, let's create some new translations. Open up **english\main.php** and add these new lines:
```php
    define('PP_ADDRESS', 'Address');
    define('PP_TELEPHONE', 'Telephone');
    define('PP_NEWENTRY', 'Add new entry');
```

Next, we'll build a simple form in index.php, but let's do it the good way and use XOOPS its form helper.

```php
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Load up the XOOPS Form Loader, which gives us access to XoopsForm
    include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    // This might look intimidating, but what we're doing is that we are creating a new form object here called $form,
    // which is based on XoopsThemeForm. We're opening up a new XoopsThemeForm and we give it some parameters.
    // PP_NEWENTRY is used as the name of the form, 'form is the description. $_SERVER['REQUEST_URI'] points the form
    // back to it's own location, so we'll submit to this page. 'post' makes it a POST method.
    $form = new XoopsThemeForm(PP_NEWENTRY, 'form', $_SERVER['REQUEST_URI'], 'post');
    // This adds a text input, with the PP_NAME, description 'Name', minimum length of 15 and maximum length of 75. True means that it's required.
    $form->addElement(new XoopsFormText(PP_NAME, 'name', 5, 75), true);
    $form->addElement(new XoopsFormText(PP_ADDRESS, 'address', 15, 50), true);
    // Telephone is an optional field.
    $form->addElement(new XoopsFormText(PP_TELEPHONE, 'telephone', 15, 50), false);
    $form->addElement(new XoopsFormText(PP_EMAIL, 'email', 15, 50), true);
    $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    // Once we're done, we're going to render the form
    $form->render();
    // And finally, we're going to display it.
    echo $form->display();

    // This file contains the footer, which contains scripts and closes our layout.
    require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```
This is an immense difficulty spike - I'm aware of that. But the best way to learn is to learn it the proper way even though that might be harder.

What we're doing here is creating a new form, which is based on the XoopsThemeForm "blueprint". We're taking that blueprint and calling it $form.
The options that we've passed through here are first the form title (which will be displayed), secondly the form name and finally we're making the form use the POST method.

Next, we are making form elements based on the blueprint. In our case, we only use XoopsFormText, which are regular text fields.
These get the following options:
* PP_NAME - our translated value
* 'name' - the name of our field, which we'll use to store the input
* 5 - the minimum length of our field
* 75 - the maximum length
* true - this makes the field required

Once we're done with adding things to the form, we're going to render it (create the code), and finally we are going to display it.

Why would we do it in this way? Well, this way has several benefits, namingly:
* Our form gets automaticly styled.
* Our form automaticly gets JavaScript validation
* This code assures that the form will get rendered well on any (well-made) theme.


Now if you click on tutorial on main menu you will see a form with name, address, telephone and email fields and a submit button. Clicking on the submit button brings you back to index.php but it doesn't do anything yet. 

Update your code so that it's like this:
```php
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Let's check if something got submitted.
    if('POST' == XoopsRequest::getMethod()) {
        if(empty(XoopsRequest::getString('name', ''))) {
            echo "Please enter a name!";
        } else {
            echo "Hi ".XoopsRequest::getString('name')."! Do you like unicorns, too?";
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
What've added here is a check wether a name has been filled in our not - our form already validates if there's input, but this relies on JavaScript.
If our user isn't allowing JavaScript, our validation is gone... that's why we are adding it here too.

If no name is entered, we're going to show an error (it will only show up if your JavaScript is disabled). 
If a name is inserted, you should see "Hi <name>! Do you like unicorns too?".

While you might be able to simply use $_POST, this is highly discouraged - the XOOPS methods have been built in such a way that these project you against all kinds of attacks!