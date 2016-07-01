#### Building a database table
Almost all modules use forms and a database in some way, so it's time for us to learn how we can create a form that will insert it's data into our database.

The first step towards this is to notify XOOPS that we're going to use the database - and as a result of that, XOOPS needs to know what tables we're going to need.
This information is specified in our mysql.sql file.

The information in this tutorial is specifically geared towards MySQL, as it is the most popular database to be used with XOOPS.
However, the basic information in this tutorial can be adapted towards the use of other database systems as well.

So, first we need to open up our **xoops_version.php** file and these new lines to the bottom of the file:
```php 
<?php
    // Database information
    // This tells XOOPS to execute this .SQL file for MySQL databases
    $modversion['sqlfile']['mysql'] = "sql/mysql.sql";
    // This tells XOOPS how many and which tables we want to use.
    $modversion['tables'][0] = basename(__DIR__)."_myform";
?>
```
The first line of new code, **$modversion['sqlfile']['mysql'] = "sql/mysql.sql";**, tells XOOPS where the sql-file is located and for what database system the sql-file is intended for.
Our second new line of code, **$modversion['tables'][0] = basename\(__\DIR\__\)."_myform";**, tells XOOPS what table it should use to execute the sql-file and what table your module is going to use. Since our module is cloneable, we're using basename\(__DIR__\) to determine the table name.

It's a good practice to start table count with 0, and it's also encouraged to put the name of your module in the table name. This makes it easier to locate and identify the tables that your module uses, should you ever need to manually edit things.
Since we've only listed 1 table, XOOPS will only create this one table - you can add a whole lot more though!

Okay, once that's done we need to tell XOOPS what to put inside those tables (the fields, properties, etc.).
To do this we need to create another folder called **sql**. Inside this new folder, we'll create a file called mysql.sql and put this code inside of the new file:

```php
CREATE TABLE tutorial_myform (
tt_id int(5) unsigned NOT NULL auto_increment,
name varchar(30) NOT NULL default '',
address varchar(30) NOT NULL default '',
telephone varchar(30) NOT NULL default '',
email varchar(30) NOT NULL default '',
PRIMARY KEY (tt_id),
KEY name (name)
) TYPE=InnoDB;
```

This is SQL-code - if you haven't used it before or if you don't understand it, search for a tutorial on SQL. It's not too hard and you'll need it all the time.

Okay, let's go over the lines of code:
* The first line, **CREATE TABLE tutorial\_myform (** tells XOOPS to create a table called **tutorial_myform**.
* The second line will create an unsigned integer that can't be null and will auto-increment called tt_id. In normal words: this is an ID that will automaticly increase (auto-increment), it can't be a negative number (unsigned), it's a whole number (integer) and it can't be empty.
* The third, fourth, fifth and sixth line will create a varchar field that can't be empty and has an empty default value. Varchars can contain almost everything (hence the name varchars, various characters).
* The seventh line will make tt_id the primary key. This makes it easier to search on (primary keys need to be unique).
* Another key is set upon name.
* The last line sets the TYPE to InnoDB. This is the most used type of MySQL databases.

Note that we are using tt_id, since id is a reserved name by MySQL and can't be used by you.

We're now ready for the next step - we've already installed our module, but it wasn't installed with database tables.
To fix this, we'll ned to uninstall our module and reinstall it. So let's do this.
* Go into module administration and remove the check from active on the tutorial module. Click Submit, confirm by clicking submit again. 
* Click back to module administration
* Click on module uninstall icon which now shows in front of the tutorial module. Confirm by clicking yes. You will now notice a red error message saying that it was unable to drop table xxx_tutorial_myform. This is correct since we told xoops there was a table in xoops_version.
* Click back to module administration.
* Now install the module Tutorial.

We now have a XOOPS module with a table at our disposal! Let's continue and actually start storing stuff in our database!

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