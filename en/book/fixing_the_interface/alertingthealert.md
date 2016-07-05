#### Alerting the alert!
Now, our module is looking great,but when we encounter errors, we still get a simple message that doesn't really pop-out.
Is there a way to change that?

Well, luckily for us, there is.

Open up **index.php** and change the code to this:
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
            $xoopsTpl->assign('msg', "<p class='bg-danger'>".PP_ENTERNAME."</p>");
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
                $xoopsTpl->assign('msg', "<p class='bg-danger'>".PP_ERROR . $xoopsDB->error."</p>");
            } else {
                $xoopsTpl->assign('msg', "<p class='bg-success'>".PP_SAVED."</p>");
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

What we've done here is adding a class (either bg-success or bg-danger) to our msg variable, like this: **"<p class='bg-success'>".PP_SAVED."</p>"**.
Because of this, our variables are now loaded wrapped in this style - so our error (or success) messages now have a style.