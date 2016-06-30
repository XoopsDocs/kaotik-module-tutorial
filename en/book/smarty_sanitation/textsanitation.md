
I have already explained this code in part 1, and there are only minor changes. Basicly, the only changes are that we assign the error and succes message to a Smarty variable called **msg**.
So, let's open up **tut_main.html** and paste this in as the very first line of code:

```php
<{$msg}>```

Now, reload your the Tutorial module form the main menu and click **Add new client**. Fill in the form and submit... and if everything went well, we should have a new client in our database!

There's one more step to conclude this part, and that's text sanitation. If you have no idea what that is - web developers have a saying, **never trust your users!**. This means that you should always play safe and assume that there could be malicious intentions from people using your site. With that being said, never allow someone to access your database using forms or gets without properly checking if the fields contain valid data types!
That's how **SQL injections** occur, by allowing people to write invalid data into forms, which then get passed to the database to be processed.
Fortunately for us, XOOPS already has a sanitation process that you can easily use in your module. Open up **index.php** and replace all the code with this:

```php
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
$xoopsOption['template_main'] = 'tut_main.html';
require(XOOPS_ROOT_PATH.'/header.php');
if (isset($_GET['addnew'])){
    $xoopsTpl->assign('addnew', 1);
}
if (isset($_POST['submit'])){
    if (empty($_POST['name'])){
        echo 'Please fill in a name';
    } else {
        $myts       = myTextSanitizer::getInstance();
        $name       = $myts->addslashes($_POST['name']);
        $address    = $myts->addslashes($_POST['address']);
        $tel        = $myts->addslashes($_POST['tel']);
        $email      = $myts->addslashes($_POST['email']);
        $query      = "INSERT INTO ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) values ('$name', '$address', '$tel', '$email' )";
        $res = $xoopsDB->query($query);
        if(!$res) {
            $xoopsTpl->assign('msg', "Error occured: $query");
        } else {
            $xoopsTpl->assign('msg', "Data was correctly inserted into DB!");
        }
    }
}
$clientdata = clientLoader();
$xoopsTpl->assign('client', $clientdata);
function clientLoader(){
    global $xoopsDB;
    $client = array();
    $q = 1;
    $query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('tutorial_myform'));
    while($myrow = $xoopsDB->fetchArray($query) )
    {
        $client[$q]['name']         = $myrow['name'];
        $client[$q]['address']      = $myrow['address'];
        $client[$q]['telephone']    = $myrow['telephone'];
        $client[$q]['email']        = $myrow['email'];
        $q++;
    }
    return $client;
}
require(XOOPS_ROOT_PATH.'/footer.php');
?>
```
Now the data can be safely placed in our database without risks of SQL injections!