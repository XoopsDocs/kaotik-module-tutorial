#### Making our module translateable
Now that we have a basic module up and running, it's time to make sure it's up to standards and make it useful for others.
First thing to do is replace the text "name" and "email" with some language constants, so that our module becomes translatable! 

To do this, we need to create a folder called **language** (important: foldernames should be all in lower case). 
Now, inside that folder let's create another folder called **english**. Inside the folder **english** create a new file called **main.php**. Now place this code inside **main.php**:
```php
<?php
    define('PP_NAME','Name');
    define('PP_EMAIL','Email');
```

Create another file in this same folder called **modinfo.php**.
Inside this file place and empty PHP tags:
```php
<?php
?>
```
Now, let's start using these language constants! Language constants allow users of your module to easily replace module text with their own native language. 
Open up index.php and change the following:

```php
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Create the headers
    echo '<div class="left">'.PP_NAME.'</div>';
    echo '<div class="right">'.PP_EMAIL.'</div>';
    // Load up the XOOPS member handler
    $member_handler =& xoops_gethandler('member');
    // Grab all our members
    $allUsers =& $member_handler->getUsers();
    // Print out our users one by one.
    foreach(array_keys($allUsers) as $i) {
        echo '<div class="left">';
        // Let's write the username
        echo $allUsers[$i]->getVar('uname');
        echo '</div>';
        echo '<div class="right">';
        // Let's write the e-mail now
        echo $allUsers[$i]->getVar('email');
        echo '</div>';
    }

    // This file contains the footer, which contains scripts and closes our layout.
    require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```

Excellent! We now have language constants in our module, which means that our module is now translateable!
As a challenge, try to add your own language as an option (it shouldn't be that hard!).