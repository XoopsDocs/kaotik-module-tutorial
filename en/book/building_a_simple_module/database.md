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