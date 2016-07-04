#### Text sanitation

We've already gone over this code in the previous chapter, and since there are only minor changes we won't go over them in detail.
Basicly, the only changes that we've done are that we assign the error and success messages to a Smarty variable called **msg** - you probably noticed that.

Now, we have added the code to show this error message, but we didn't add anything to display the error message. We should probably change that, so open up **people_main.html** and add this bit of code as the very first line:
```php
<{$msg}>
```

Now, reload your module form the main menu and click **Add new person**. Fill in the form with some data and submit the form... and if everything went well, we should have a new person in our database!

There's one more step to conclude this part, and that's text sanitation. If you have no idea what that is - web developers have a saying, **never trust your users!**. This means that you should always play safe and assume that there could be malicious intentions from people using your site. With that being said, never allow someone to access your database using forms or gets without properly checking if the fields contain valid data types!
That's how **SQL injections** occur, by allowing people to write invalid data into forms, which then get passed to the database to be processed.
Fortunately for us, XOOPS already has a sanitation process that you can easily use in your module. In fact, we've been using that all the time already!

The **$xoopsDB->escape** function that we've been using has been taking care of it for us, as that's one of the handy benefits XOOPS gives us.

At the end of our second chapter, your **index.php** should look like this:

```php
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // Specify what template to use
    $xoopsOption['template_main'] = 'people_main.html';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Check if we got any POST data
    if('POST' == Xmf\Request::getMethod()) {
        // If the name isn't filled in...
        if(empty(Xmf\Request::getString('name', ''))) {
            // Display an error.
            $xoopsTpl->assign('msg', PP_ENTERNAME);
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
                $xoopsTpl->assign('msg', PP_ERROR . $xoopsDB->error);
            } else {
                $xoopsTpl->assign('msg', PP_SAVED);
            }
        }
    } else {
        // Let's check if we should load the new people form or not..
        if((Xmf\Request::getString('addnew')) == true) {
            // Assign true to addNew
            $xoopsTpl->assign('addNew', 1);
        }
    }
    $personData = personLoader();
    $xoopsTpl->assign('persons', $personData);
    function personLoader() {
        // Get the global xoopsDB
        global $xoopsDB;
        // Create a new empty array client
        $client = array();
        // A nice counter set to 1
        $i = 1;
        // Let's create our query.
        $query = $xoopsDB->query('SELECT * FROM '. $xoopsDB->prefix(basename(__DIR__).'_myform'));
        // Perform our query and loop through it
        while($myRow = $xoopsDB->fetchArray($query)) {
            // First run, this will be $client[1]['name'], next one $client[2]['name'], etc.
            $person[$i]['name']         =   $myRow['name'];
            $person[$i]['address']      =   $myRow['address'];
            $person[$i]['telephone']    =   $myRow['telephone'];
            $person[$i]['email']        =   $myRow['email'];
            // Let's add one to the counter
            $i++;
        }
        // Let's return our array.
        return $person;
    }
    // This file contains the footer, which contains scripts and closes our layout.
    require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```
Now the data can be safely placed in our database without risks of SQL injections!