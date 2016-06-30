#### Building a form
We've gotten quite far, so let's take the last hurdle and finish our first module!
In order to store things in our database, we use a form. 

Let's get to work and start building this form.

**Note: this form uses tables, but this doesn't work that well on mobile devices. We're working hard on alternatives, and in XOOPS 2.6 we advice to use div instead of tables.**

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
        </tr>
        <tr>
            <td align="right">Address</td>
            <td><input type="text" name="address"></td>
        </tr>
        <tr>
            <td align="right">Telephone</td>
            <td><input type="text" name="tel"></td>
        </tr>
        <tr>
            <td align="right">Email</td>
            <td><input type="text" name="email"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="submit"></td>
        </tr>
    </table>
</form>
<?php
require(XOOPS_ROOT_PATH.'/footer.php');
?>
```
Now if you click on **Tutorial** on the main menu you will see a form with name, address, telephone and email fields and a submit button. Clicking on the submit button brings you back to index.php but doesn't do anything.
That's because we didn't add any logic to do something with the submitted information. Let's change that! 

Change the following code at the top of our file. Keep in mind that the code is shortened and not everything is shown to preserve space.
Your index.php should still contain all the code.
```php
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
if (isset($_POST['submit'])){
    echo 'Hi, '. $_POST['name'] .', do you like unicorns?';
}
?>
```
Now, when you submit the form again, you'll get a nice greeting and a question back. What I should see is: **Hi, Kevin, do you like unicorns?**. The question to that is obviously yes.
Let me explain what is happening: the PHP command if is a conditional control: IF something is TRUE, it will return something. If it's FALSE, it won't return anything.

In our case, it's checking wether or not the $_POST\['submit'\] superglobal exists. What this means is that it's checking wether or not the submit button has been clicked (that's why we named the button submit).
Since we have clicked it, it will say hi to us and print our name.

Now try to submit the form, but don't fill in anything. What happens in this case?
Well, our module is still saying hi and asking a question, but it's not pointed to anybody. Why's that? Because we're not checking if the form has been submitted with information in it.
Let's change that by modifiying the code. I've added some extra comments to keep things clear. 
```php
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
// If the submit button has been clicked...
if (isset($_POST['submit'])){
    // Then we'll check if a name has been filled in...
    if (empty($_POST['name'])){
        // But it is not :(... Let's return an error
        echo 'Please fill in a name';
    } else {
        // Shouldn't really be needed to ask this question... who doesn't like them?
        echo 'Hi, '. $_POST['name'] .', do you like unicorns?';
    }
}
?>
```
If you press submit now with an empty name just gives you an error message.
You'll notice that we're using an IF condition inside of another IF - you can do as many as you like (but it could become rather slow..). 
This means that if the submit button hasn't been clicked, we won't check if the name has been filled in - if the form wasn't submitted, we would always show the error message, even when we load the page the first time!

I think we've got this under control - it's time to go a bit further and store our information in the database!