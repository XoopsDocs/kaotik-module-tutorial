#### Saving to the database

Finally, we have arrived at storing our information! We will now insert the form data that we enter into our database table. I hope you're ready!

```php 
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
if (isset($_POST['submit'])){
    if (empty($_POST['name'])){
        echo 'Please fill in a name';
    } else {
        // $_POST contains all the information from our form. We're creating a new variable to contain the submitted information.
        // This way, we can easily put them through to the database.
        $name       =   $_POST['name'];
        $address    =   $_POST['address'];
        $tel        =   $_POST['tel'];
        $email      =   $_POST['email'];
        // All values are done, let's prepare our SQL-query to store this information
        $query      =   "INSERT INTO ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) VALUES ('$name', '$address', '$tel', '$email' )";
        // Let's perform the query
        $res        =   $xoopsDB->query($query);
        if (!$res) {
            echo "We've encountered an error: $query";
        } else {
            echo "Data was correctly inserted into the database!";
        }
    }
}
?>
```

The first 4 lines of new code set up variables which contain the form information. Upon sending a form, all information is stored in the **$_POST** superglobal.
The next line, **$query**, sets up the query that will be used to actually insert our data.
The line **$res** then performs this query, and with the next line we check if the data was inserted or not.

If everything went good, we should see **Data was correctly inserted into the database!". If something went wrong, we'll see the error.

!!!TODO: Add a block about text sanitation in XOOPS!!!

**This code however is **NOT** ready to be used in your module as it lacks text sanitation - in simple words: it's DANGEROUS AND YOU SHOULD NOT USE THIS CODE ON YOUR SITE.
If you do use it, your site is easily hacked.**

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