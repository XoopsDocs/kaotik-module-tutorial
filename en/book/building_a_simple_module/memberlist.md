#### Creating a member list
Let's take this a step further! We're going to create a simple list of our users. 

Let's replace **echo "Hello world!";** with this code:
(Don't worry if this looks intimidating - we're going over each and every line below!).

```php
$member_handler =& xoops_gethandler('member');
$foundusers =& $member_handler->getUsers();
foreach (array_keys($foundusers) as $j) {
    echo $foundusers[$j]->getVar("uname").'<br>';
}
```
Load up your website and you should see a list of all your current users! Neat huh?

Let's review what each line does:
* The first line calls a XOOPS handler that deals with member (user) tasks, and we assign this to the name $member_handler.
* The second line uses this handler and calls the method getUsers(), which will place all users in the $foundusers variable.
* The next three lines loop through this list and prints out the username as well as a new line.

If this still looks intimidating to you, I suggest you try some other tutorials first which explain the basics of PHP - this isn't rocket science, but a bit of experience behind your belt can help.

Now, let's say that we want to see **everything** about our users - well, that's possible! **However, only use this on test sites - you don't want to show this much information on a public site!**

Modify our file so that it looks like this:

```php
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Load up the XOOPS member handler
    $member_handler =& xoops_gethandler('member');
    // Grab all our members
    $allUsers =& $member_handler->getUsers();
    // Now let's loop through all our users
    foreach(array_keys($allUsers) as $i) {
        var_dump($allUsers[$i]);
        echo '<br>';
    }
    // This file contains the footer, which contains scripts and closes our layout.
    require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```
What you'll see now is a big list that looks very confusing, but shows all the information about your users that you can use.
If you've got xdebug installed, it should be presented in a orderly list though (don't worry if you don't know what xdebug is - that's way beyond our scope here).

Now, with a list like this we're not getting far - it's chaotic! Let's create some order in all the chaos and make it easier to understand.

Let's create a header and a table which contains both the name of our users as well as the e-mail. 
I'm going to show you an easy way to do this - as always, there might be other and better ways - but this one is simple and easy.

We're going to add some new lines to our code, but first let's delete everything we added before - for simplicity, here's what we should have once we're done:

```php
<?php
// Tutorial 
// Created by KaotiK
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
?>
<table width="100" border="0">
    <tr>
        <td>Name</td>
        <td>Email</td>
    </tr>
</table>
<?php
require(XOOPS_ROOT_PATH.'/footer.php');
?>
```
If you get an error, check if you added the **?>** below **require(XOOPS_ROOT_PATH.'/header.php');** and the  **<?php** above **require(XOOPS_ROOT_PATH.'/footer.php');**.

Now click on Tutorial from your main menu and you will see a table saying Name and Email. Great, but it's still empty... it's time to place some information to it.

Once again, here's the complete new code:

```php
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Create the headers
    echo '<div class="left">Name</div>';
    echo '<div class="right">E-mail</div>';
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

Ahhh, much better! Now we have a nice overview of our users their usernames as well as their emails. Now, let's bring some more XOOPS standards into our code!
The next step we're going to take is to make our module translateable.