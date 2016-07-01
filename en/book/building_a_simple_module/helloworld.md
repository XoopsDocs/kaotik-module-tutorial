# Getting our first module up and running
Welcome to the path to building your first XOOPS module! Don't worry, it's actually not that hard as you think, and we'll walk you through every step of it.

Should you get stuck, don't worry and feel free to ask for help on our [official forums](http://xoops.org/modules/newbb/viewforum.php?forum=65).

## Getting started
In order to create our first module, we'll need to set-up some files and a directory structure. Let's get right to it!

First, create a folder called **people**. In that folder, we'll create a few more folders: 
* images
* include
* language
	* english
* sql

Don't worry if you don't understand what each of this folders is for, they will all get explained later.

With this, the basic structure of our module is finished and we can get started with creating files!

The first step we'll take towards this is to create a nice logo for our module, which will be used in the Module Administration! You can make your own or use the one that I created:
![logoModule.png](../assets/logoModule.png)

Download (or move) the image to the **images** folder, so that our module exists out of these files:
* images
    * tutorial.png
* language
    * english
* sql

Great! Now it's time to really get started and create our first PHP-file. For that, we're going to create the file **xoops_version.php** which we'll store in the root of our module.
Open up the **xoops_version.php** file in your preferred code editor (like [NotePad++](https://notepad-plus-plus.org/), [Sublime Text](http://sublimetext.com), [Visual Studio Code](https://code.visualstudio.com/), [Atom](http://atom.io), [Brackets](http://backets.io), [PhpStorm](https://www.jetbrains.com/phpstorm),...).

We're going to add this to this file - don't worry, I've commented everything:
```php
<?php
	// People Module, by KaotiK and kevinpetit

	// The line below will make sure that our module is cloneable. If you change the name of the folder, it will still work.
	$modversion['name'] = ucfirst(basename(__DIR__));
	// The version of our module.
	$modversion['version'] = 1.00;
	// A description of our first module!
	$modversion['description'] = "Our very first module that contains a people database!";
	// The authors of the module. You may put your own name here :)
	$modversion['author'] = "KaotiK & kevinpetit";
	// The credits of the module. Always credit everyone ;).
	$modversion['credits'] = "KaotiK & kevinpetit";
	// A link to the help page. We don't have one.
	$modversion['help'] = "";
	// The license of our module. This **SHOULD ALWAYS BE GNU GPL**.
	$modversion['license'] = "GNU GPL 2 or later";
	// Wether or not our module is an official XOOPS module. It is not.
	$modversion['official'] = 0;
	// The image that will be shown in the XOOPS admin.
	$modversion['image'] = "images/people.png";
	// This makes sure that our module still works if the name of our module is changed.
	$modversion['dirname'] = basename(__DIR__);
	// If we want to have a backend to our module, we can enable this here.
	$modversion['hasAdmin'] = 0;
	// If we want our module to show up in the main menu, we set this to 1.
	$modversion['hasMain'] = 1;
?>
```

If you don't understand this, I suggest you first follow a basic PHP course like (https://www.codecademy.com/learn/php)[this one from Codecademy] - once you've done that one, you should have a better understanding of what's going on.

Because we named our module it's directory **people**, the name of our module and the dirname will automaticly be set to **people** as well. This is a best-practice, since this allows people to re-use a module by renaming it. For example, you might want to use our module to manage both your staff and your clients - if you rename the folder to staff and another one clients, this will allow you to use a pretty link like **/modules/staff** and **/modules/client** for your site.

This file tells XOOPS about our module - it's the first file that XOOPS looks for as it's the file that contains all the information about our module. It tells where the image of our module is, the name, the description, the authors, etc. So it's a pretty important file!

Now that we understand and built the **xoops_version.php** file, let's install our module and check if it works...
So, let's upload our module, go to the XOOPS administration panel and let's go the modules and install our module.
When it's installed, let's check it out on our website - click on Tutorial in your main menu, and... you'll see an empty page!

Why's that? Well, we haven't created an index file yet, so XOOPS has nothing to load! Let's fix that and create a new file **index.php** in the root of our module.
Add this code to it:

```php 
<?php 
	// This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
	require_once dirname(dirname(__DIR__)) . '/mainfile.php';
	// This file contains the header and layout of our XOOPS website.
	require_once XOOPS_ROOT_PATH . '/header.php';
	// This file contains the footer, which contains scripts and closes our layout.
	require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```
So, what do these lines do? These load the XOOPS environment for us, so we can use all the handy features that XOOPS has to offer us.
The main responsible for this is **require_once dirname(dirname(__DIR__)) . '/mainfile.php';** - this is the main XOOPS file which contains boots up XOOPS for us and allows us to access all of XOOPS its features.

The **include __DIR__ . '/include/header.php';** is responsible for loading up the XOOPS header, which makes your module look like it's part of XOOPS.

The **include __DIR__ . '/include/footer.php';** loads up extra scripts and 'finishes' the page.

So, let's try to make our module a bit less like a blank canvas and add something!

Add, between the **include __DIR__ . '/include/header.php';** and **include __DIR__ . '/include/footer.php';** lines the following code: **echo "Hello world!";**, so that it looks like this:

```php
<?php
	// This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
	require_once dirname(dirname(__DIR__)) . '/mainfile.php';
	// This file contains the header and layout of our XOOPS website.
	require_once XOOPS_ROOT_PATH . '/header.php';
	// Let's say Hello World!
	echo 'Hello World!';
	// This file contains the footer, which contains scripts and closes our layout.
	require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```

When you now go to your website and reload the Tutorial module, the words "Hello world!" will appear on your site - congratulations, your first module is a fact!
But we're not happy yet with this... let's continue and create a user list!