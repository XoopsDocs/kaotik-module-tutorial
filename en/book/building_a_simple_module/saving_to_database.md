#### Saving to the database

Finally, we have arrived at storing our information! We will now insert the form data that we enter into our database table. I hope you're ready!
Before we actually store the data, we're going to have a talk about safety on the internet - no, not the dull kind.
If we would simply add things to the website, without checking them, it would be very insecure as our user might be up to no good!
What if he tries to do a SQL-injection attack (which allows them to see ALL content in the database, or even worse, can delete everything).

The way to avoid this is text-sanitation. This way, we're checking everything that our user is doing and we're preventing them to write code that can be executed.
Should our user write code, it would be escaped and because of that, it wouldn't be executable anymore and it can't harm us.
In the next example, text sanitation is already included. More information about this subject is available in another tutorial

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
        //  You should NEVER trust anything that your users post - always first check it.
        // We're going to call the TextSanitizer to sanitize/clean their input.
        $myts = myTextSanitizer::getInstance();
        // $_POST contains all the information from our form. We're creating a new variable to contain the submitted information.
        // This way, we can easily put them through to the database.
        $name       =   $myts->addslashes($_POST['name']);
        $address    =   $myts->addslashes($_POST['address']);
        $tel        =   $myts->addslashes($_POST['tel']);
        $email      =   $myts->addslashes($_POST['email']);
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

Next, we'll list everything in our database!