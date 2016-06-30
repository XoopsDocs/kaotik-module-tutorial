#### Making our module translateable
Now that we have a basic module up and running, it's time to make sure it's up to standards and make it useful for others.
First thing to do is replace the text "name" and "email" with some language constants, so that our module becomes translatable! 

To do this, we need to create a folder called **language** (important: foldernames should be all in lower case). 
Now, inside that folder let's create another folder called **english**. Inside the folder **english** create a new file called **main.php**. Now place this code inside **main.php**:
```php
<?php
define('TT_NAME','Name');
define('TT_EMAIL','Email');
?>
```

Create another file in this same folder called modinfo.php.
Inside this file place and empty PHP tags:
```php
<?php
?>
```
Now, let's start using these language constants! Language constants allow users of your module to easily replace module text with their own native language. 
Open up index.php and change the following:

```php
<?php
// Tutorial
// Created by KaotiK
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
echo '<table width="100" border="0">
<tr>
    <td>'.TT_NAME.'</td>
    <td>'.TT_EMAIL.'</td>
</tr>';
$member_handler =& xoops_gethandler('member');
$foundusers =& $member_handler->getUsers();
    foreach (array_keys($foundusers) as $j) {
        // This pastes the username and email together in 
        echo '<tr>';
            echo '<td>';
                // Let's write the username
                echo $foundusers[$j]->getVar("uname");
            echo '</td>';
            echo '<td>';
                echo $foundusers[$j]->getVar("email");
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';
require(XOOPS_ROOT_PATH.'/footer.php');
?>
```

Excellent! We now have language constants in our module, which means that our module is now translateable!
As a challenge, try to add your own language as an option!