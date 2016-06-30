#### Listing information in the database

Okay, the last step we're going to learn is to create a button that will list **all content** in our table.

To do this, we're going to create a big chunk of code:

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
    $query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('tutorial_myform'));
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
        $query = "INSERT INTO ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) VALUES ('$name', '$address', '$tel', '$email' )";
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
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
if (isset($_POST['listall'])){
    echo '<table width="100" border="0">
    <tr>
        <td>'.TT_NAME.'</td>
        <td>'.TT_ADDRESS.'</td>
        <td>'.TT_TELEPHONE.'</td>
        <td>'.TT_EMAIL.'</td>
    </tr>';
    $query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('tutorial_myform'));
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
        echo 'please fill in a name';
    } else {
        $name       = $_POST['name'];
        $address    = $_POST['address'];
        $tel        = $_POST['tel'];
        $email      = $_POST['email'];
        $query      = "INSERT INTO ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) VALUES ('$name', '$address', '$tel', '$email' )";
        $res = $xoopsDB->query($query);
        if(!$res) {
            echo "Error occured: $query";
        } else {
            echo "Data was correctly inserted into database!";
        }
    }   
}
?>
<form name="tutorial_form" method="post" action="index.php">
    <table width="400" border="0">
        <tr>
            <td align="right"><?php echo TT_NAME; ?></td>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <td align="right"><?php echo TT_ADDRESS; ?></td>
            <td><input type="text" name="address"></td>
        </tr>
        <tr>
            <td align="right"><?php echo TT_TELEPHONE; ?></td>
            <td><input type="text" name="tel"></td>
        </tr>
        <tr>
            <td align="right"><?php echo TT_EMAIL; ?></td>
            <td><input type="text" name="email"></td>
        </tr>
        <tr>
            <td><input type="submit" name="listall" value="List All"></td>
            <td><input type="submit" name="submit" value="submit"></td>
        </tr>
    </table>
</form>
<?php
require(XOOPS_ROOT_PATH.'/footer.php');
?>
```

Congratulations, that's the end of this tutorial! I hope you've learned quite a bit and are ready to get started on building your first awesome module!
Good luck!