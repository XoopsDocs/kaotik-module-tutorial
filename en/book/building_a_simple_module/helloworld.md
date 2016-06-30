#### Getting our first module up and running
When you open up the Tutorial module, you will see that it exists out of these files and directories:
* images
    * tutorial.png
* language
    * english
        * main.php
        * modinfo.php
* sql
    * mysql.sql
* index.php
* xoops_version.php

These files are all we need to get started - so let's get to it. Open up the **xoops_version.php** in your preferred code editor (like [https://notepad-plus-plus.org/](NotePad++), [http://sublimetext.com](Sublime Text), [https://code.visualstudio.com/](Visual Studio Code), [http://atom.io](Atom), [http://backets.io](Brackets), [https://www.jetbrains.com/phpstorm](PhpStorm),...).
In this tutorial, I will use PhpStorm, but you can use any editor you want.

When you open up the **xoops_version.php** file, you'll see this: 
```php
<?php
// Tutorial module
// Created by kaotik
$modversion['name'] = "Tutorial";
$modversion['version'] = 1.00;
$modversion['description'] = "This is a tutorial module to teach how to build a simple module";
$modversion['author'] = "KaotiK";
$modversion['credits'] = "KaotiK";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/tutorial.png";
$modversion['dirname'] = "tutorial";
// Admin
$modversion['hasAdmin'] = 0;
// Menu
$modversion['hasMain'] = 1;
?>
```

Now let's go through what this all means.

```php
<?php
// Tutorial module
// Created by kaotik
```
If you have ever worked with PHP, this should be very easy to understand - if not, let me explain it to you.
The first line, which contains **<?php**, which is the PHP code tag, starts our PHP code. As long as we don't close our tag, we're in PHP mode. In the last line, we use the closing tag for this, which is **?>**.

It's a good practice to not place spaces in front of the **<?php* tag, as this can cause issues on some configurations.

The next two lines are comments, which means that it is text which won't be processed by PHP. This is handy to write down some information.
In this case, we've listed the name of the module as well as the author. Keep in mind that these comments are *optional* and your module will still work if you remove them.
```php
$modversion['name'] = "Tutorial";
$modversion['version'] = 1.00;
$modversion['description'] = "This is a tutorial module to teach how to build a simple module";
```
These lines are our module "configuration values". To keep it simple, we're going to store information in a keyword.
Think of it like having a list (called $modversion), in which we have a key (name) which stores a value (Tutorial).

What matters here is that these keys contain the configuration information about the module.
In the example above, both the **name**, **version** and **description** are set.

```php
$modversion['author'] = "KaotiK";
$modversion['credits'] = "KaotiK";
$modversion['help'] = "";
```

Here we set both the **author**, **credits** and **help** values. Help isn't required, and in our example we aren't using it.
If you decide to use it, you can point to a file or a link with more information.

```php
$modversion['license'] = "GPL";
$modversion['official'] = 0;
$modversion['image'] = "images/tutorial.png";
$modversion['dirname'] = "tutorial";
```

And this is where it starts to get interesting. Here we set the **license** that our module uses - however, this should **always** be GPL, as the XOOPS Core is licensed under the GPL license, which requires any derivative works to be licensed under the GPL as well (if you don't understand this - don't worry - the only thing you need to know is that the answer here is always GPL).

The official value is used to mark modules as being official modules that are supported by the XOOPS team. Normally, you'll keep this on 0.

Image is the image that will be used for your module in the XOOPS admin. In our case, that's the **images/tutorial.png** file. 
You can find a blank version of that image on the [http://www.xoops.org](XOOPS website).

Last, we have dirname, which is the name of the directory in which we store our module. Since our module is called tutorial, it's only logic that we call this "tutorial".
Try to give your modules logical names, as these are shown in the URL of your site - something called **pinkfluffyunicornsarebackforrevenge** might not be the best choice for a news module.


```php
// Admin
$modversion['hasAdmin'] = 0;
// Menu
$modversion['hasMain'] = 1;
?>
```
And this is the most interesting part of the file - **hasAdmin** and **hasMain**.
These values control wether or not there is an administration part for your module, or if the module has an entry in the main menu.
If you set both of these to 0, it will still show up in the XOOPS Administration, so you can still uninstall it.
hasAdmin=0 means there is no administration part to this module. Since I want the module to appear on the main menu I've set hasMain to 1. If I had set it to 0 then it wouldn't show up on main menu. If you set hasAdmin and hasMain both to 0, it will still show up on module administration allowing 

As explained before, the *?>* stops the PHP code and returns us to normal HTML (which we don't need in this case).

**Using index.php**

Now that we understand the **xoops_version.php** file, let's install our module and check if it works...
So, let's upload our module, go to the XOOPS administration panel and let's go the modules and install our module.
When it's installed, let's check it out on our website - click on Tutorial in your main menu, and... you'll see an empty page!

We're going to check now why the page is blank.

```php 
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
require(XOOPS_ROOT_PATH.'/footer.php');
?>
```
You'll notice 3 lines you haven't seen before - all the other lines should be familiar to you.

So, what do these lines do? These load the XOOPS environment for us, so we can use all the handy features that XOOPS has to offer us.
The main responsible for this is **require('../../mainfile.php');** - this is the main XOOPS file which contains all of the configuration values and gives us access to the information about our users!

The **require(XOOPS_ROOT_PATH.'/header.php');** is responsible for loading up the XOOPS header, which makes your module look like it's part of XOOPS.

The **require(XOOPS_ROOT_PATH.'/footer.php');** loads up extra scripts and 'finishes' the page.

So, let's try to make our module a bit less like a blank canvas and add something!

Add, between the **require(XOOPS_ROOT_PATH.'/header.php');** and **require(XOOPS_ROOT_PATH.'/footer.php');** lines the following code: **echo "Hello world!";**, so that it looks like this:

```php
<?php
// Tutorial 
// Created by KaotiK 
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
echo "Hello world!";
require(XOOPS_ROOT_PATH.'/footer.php');
?>
```

When you now go to your website and reload the Tutorial module, the words "Hello world!" will appear on your site - congratulations, your first module is a fact!
But we're not happy yet with this... let's continue and create a user list!