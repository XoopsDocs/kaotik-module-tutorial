#### Building a database table
Almost all modules use forms and a database in some way, so it's time for us to learn how we can create a form that will insert it's data into our database.

The first step towards this is to notify XOOPS that we're going to use the database - and as a result of that, XOOPS needs to know what tables we're going to need.
This information is specified in our mysql.sql file.

The information in this tutorial is specifically geared towards MySQL, as it is the most popular database to be used with XOOPS.
However, the basic information in this tutorial can be adapted towards the use of other database systems as well.

So, first we need to open up our **xoops_version.php** file and add 2 lines (the last 3 lines):
```php 
<?php
// Tutorial Module 
// Created by kaotik
$modversion['name'] = "Tutorial";
$modversion['version'] = 1.00;
$modversion['description'] = "This is a tutorial module to teach how to build a simple module";
$modversion['author'] = "KaotiK";
$modversion['credits'] = "KaotiK";
$modversion['help'] = "";
$modversion['license'] = "GPL";
$modversion['official'] = 0;
$modversion['image'] = "images/tutorial.png";
$modversion['dirname'] = "tutorial";
// Admin
$modversion['hasAdmin'] = 0;
// Menu
$modversion['hasMain'] = 1;
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "tutorial_myform";
?>
```
The first line of new code, **$modversion['sqlfile']['mysql'] = "sql/mysql.sql";**, tells XOOPS where the sql-file is located and for what database system the sql-file is intended for.
Our second new line of code, **$modversion['tables'][0] = "tutorial_myform";**, tells XOOPS what table it should use to execute the sql-file and what table your module is going to use.

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
* The first line, **CREATE TABLE tutorial_myform (** tells XOOPS to create a table called **tutorial_myform**.
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
Using Forms and a Database
Let's build a simple form in index.php

```php
<?php
// Tutorial
// Created by KaotiK
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
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
<td>&nbsp;</td>
<td><input type="submit" name="submit" value="submit"></td>
</tr>
</table>
</form>
<?php
require(XOOPS_ROOT_PATH.'/footer.php');
?>
```

Now if you click on tutorial on main menu you will see a form with name, address, telephone and email and a submit button. Clicking on the submit button brings you back to index.php but doesn't do anything. 

Insert the following code:
```php
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
if (isset($_POST['submit'])){
echo 'my name is: '. $_POST['name'];
}
?>
```

I've only placed the top part of the code to keep this page smaller. Your index.php file should have the entire code.
Now when you click on submit you get a line of text saying "my name is: " and your name. Let me explain what is happening. The php command if is a conditional control. IF something is TRUE (for ex.) then DO something. In this case IF the form button was pressed then print the statment. The submit button is ```$_POST['submit']``` the name 'submit' comes from the name of our button and to check if it exists I used ```isset``` which returns TRUE if it does exist and FALSE if it does not.
Now try pressing submit without filling anything. You will notice that it still prints "my name is: " but without a name. Let's create an error message if no name is filled in.

```php
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
if (isset($_POST['submit'])){
if (empty($_POST['name'])){
echo 'please fill in a name';
} else {
echo 'my name is: '. $_POST['name'];
}
}
?>
```

Pressing submit with an empty name now prints an error message. You will notice that I'm using an IF condition inside another IF. It's saying: if the form field named "name" is empty then print 'please fill in a name' if not (else) ```'my name is: '. $_POST['name']```

**Putting Data into the DB**

Let's take this a step further. We will now insert the form data into our DB table.

```php 
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
if (isset($_POST['submit'])){
if (empty($_POST['name'])){
echo 'please fill in a name';
} else {
$name=$_POST['name'];
$address=$_POST['address'];
$tel=$_POST['tel'];
$email=$_POST['email'];
$query = "Insert into ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) values ('$name', '$address', '$tel', '$email' )";
$res=$xoopsDB->query($query);
if(!$res) {
echo "error: $query";
} else {
echo "Data was correctly inserted into DB!";
}
}
}
?>
```

The first 4 lines of new code create variables set to form values. I've done it this way for a better understanding of what's happening. The next line $query builds the line that will be used by $xoopsDB in

```php
$res=$xoopsDB->query($query);
```

The next line:

```php
if(!$res)
```

checks if any error occurred when accessing the DB. If all went fine print "Data was correctly inserted into DB!". In later tutorials I will teach you about text sanitation and it's importance.
Listing table contents

Now we are going to create a button to list all the content in our table.

```php
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
if (isset($_POST['listall'])){
echo '<table width="100" border="0">
<tr>
<td bgcolor="#99cc99">Name</td>
<td bgcolor="#66cc99">Address</td>
<td bgcolor="#99cc99">Telephone</td>
<td bgcolor="#66cc99">Email</td>
</tr>';
$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('tutorial_myform'));
while($myrow = $xoopsDB->fetchArray($query) )
{
$name = $myrow['name'];
$address = $myrow['address'];
$telephone = $myrow['telephone'];
$email = $myrow['email'];
echo '<tr><td bgcolor="#99cc99">'.$name.'</td><td bgcolor="#66cc99">'.$address.'</td><td bgcolor="#99cc99">'.$telephone.'</td><td bgcolor="#66cc99">'.$email.'</td></tr>';
}
echo '</table>';
}
if (isset($_POST['submit'])){
if (empty($_POST['name'])){
echo 'please fill in a name';
} else {
$name=$_POST['name'];
$address=$_POST['address'];
$tel=$_POST['tel'];
$email=$_POST['email'];
$query = "Insert into ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) values ('$name', '$address', '$tel', '$email' )";
$res=$xoopsDB->query($query);
if(!$res) {
echo "error: $query";
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

There are 2 changes here. One is a new button named listall that, when pressed will list all rows in our table. The other is an IF condition to check if the listall button was pressed. 
There is one more thing to do, that is replace the text with language constants so let's take care of that. Open file main.php found in folder /language/english and add this code:```

```php
<?php
define('TT_NAME','Name');
define('TT_EMAIL','Email');
define('TT_ADDRESS','Address');
define('TT_TELEPHONE','Telephone');
?>
```

Here is the final code for index.php:
```php 
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
if (isset($_POST['listall'])){
echo '<table width="100" border="0">
<tr>
<td bgcolor="#99cc99">'.TT_NAME.'</td>
<td bgcolor="#66cc99">'.TT_ADDRESS.'</td>
<td bgcolor="#99cc99">'.TT_TELEPHONE.'</td>
<td bgcolor="#66cc99">'.TT_EMAIL.'</td>
</tr>';
$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('tutorial_myform'));
while($myrow = $xoopsDB->fetchArray($query) )
{
$name = $myrow['name'];
$address = $myrow['address'];
$telephone = $myrow['telephone'];
$email = $myrow['email'];
echo '<tr><td bgcolor="#99cc99">'.$name.'</td><td bgcolor="#66cc99">'.$address.'</td><td bgcolor="#99cc99">'.$telephone.'</td><td bgcolor="#66cc99">'.$email.'</td></tr>';
}
echo '</table>';
}
if (isset($_POST['submit'])){
if (empty($_POST['name'])){
echo 'please fill in a name';
} else {
$name=$_POST['name'];
$address=$_POST['address'];
$tel=$_POST['tel'];
$email=$_POST['email'];
$query = "Insert into ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) values ('$name', '$address', '$tel', '$email' )";
$res=$xoopsDB->query($query);
if(!$res) {
echo "error: $query";
} else {
echo "Data was correctly inserted into DB!";
}
}
}
?>
<form name="tutorial_form" method="post" action="index.php">
<table width="400" border="0">
<tr>
<td align="right"><?php echo TT_NAME; ?></td>
<td><input type="text" name="name"></td>
</tr><tr>
<td align="right"><?php echo TT_ADDRESS; ?></td>
<td><input type="text" name="address"></td>
</tr><tr>
<td align="right"><?php echo TT_TELEPHONE; ?></td>
<td><input type="text" name="tel"></td>
</tr><tr>
<td align="right"><?php echo TT_EMAIL; ?></td>
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

That completes this tutorial. I hope you found it usefull.
Here is the completed module. Check this with your own code to see if they match.