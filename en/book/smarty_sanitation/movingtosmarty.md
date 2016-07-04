#### The move to Smarty!
Before we get started, make sure you have the completed module we created in chapter 1 installed in your installation of XOOPS.

If you open up **index.php**, you'll notice that there is a big mixture of PHP code and HTML, which is far from optimal. In big modules it can get very hard and difficult to read what what is for. And that's where Smarty comes it, as it allows us to create HTML templates that are easy to read and modify, yet they can be generated dynamically. 
XOOPS uses Smarty, and extends it even further so it can use its own special codes to offer us even more functionality.

So let's create our first XOOPS Smarty template! However, before we can do that, we need to specify the template in our **xoops_version.php** file. So open that up and add this code::

```php
<?php
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

    // Database information
    // This tells XOOPS to execute this .SQL file for MySQL databases
    $modversion['sqlfile']['mysql'] = "sql/mysql.sql";
    // This tells XOOPS how many and which tables we want to use.
    $modversion['tables'][0] = basename(__DIR__)."_myform";

    // Templates
    $modversion['templates'][1]['file'] = 'people_main.html';
    $modversion['templates'][1]['description'] = '';
?>
```
What this does is telling XOOPS to add a template called **people_main.html** to the database. So now, let's create a directory in the tutorial module called **templates**, and within that folder we'll create an HTML file called **tut_main.html**. 
**NOTE: normally, all template files used by XOOPS use .html. Make sure that there is NO code inside this file at all - it should be an empty file!**
Now, go to the aminidstration and update the Tutorial module - you will notice that tut_main.html gets processed by XOOPS.
Great! Let's go to the next step!

Smarty templates are just plain old and simple HTML pages with some special code, which in the case of XOOPS is enclosed with **<{}>**. For example, if you would want the XOOPS URI in a smarty template, you would use <{$xoops_url}>.

To keep this chapter simple, we're going to use an alternative method so that our code doesn't get too complicated. Rename file **index.php** to **index_original.php**, and create a new index.php file with the following code:

```php
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // Specify what template to use
    $xoopsOption['template_main'] = 'people_main.html';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    // Put some content in the template.
    $xoopsTpl->assign('mytest', 'Hello World!');
    // This file contains the footer, which contains scripts and closes our layout.
    require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```
This code has two new lines, the first one, **$xoopsOption** tells XOOPS which template should be used here, which is in our case **people_main.html**.
The second is where Smarty shows in all it's glory: we can assign PHP vars to Smarty vars. What does this mean? In this case the smarty variable 'mytest' will be replaced in our Smarty template with 'Hello World!'.
Now, open up the Smarty template in **/templates/people_main.html** and type in **<{$mytest}>**.
Load up our module once again from the main menu and you will see **"Hello World!"** appear.
If nothing appears, go to your Module Administration and update your module.

Great! We now have a working Smarty template for the main page of our module. Now let's take this further to create the same functionality from chapter 1!
In chapter 1, we had a table with 4 columns that listed information from our database, let's try and re-create this table header in our smarty template.

Remove **<{$mytest}>** from the template and replace it with this text:


```html
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><{$smarty.const.PP_NAME}></td>
        <td><{$smarty.const.PP_ADDRESS}></td>
        <td><{$smarty.const.PP_TELEPHONE}></td>
        <td><{$smarty.const.PP_EMAIL}></td>
    </tr>
</table>
```

If you now reload the tutorial module, you'll see a table with 4 columns! You'll notice that we're now using **$smarty.const** to retrieve our language constants which are set in **/tutorial/language/english/main.php. There is an alternative way of setting constants using **$xoopsTpl->assign**, but you shouldn't bother about this as it adds an extra line of code to worry about.

Now, let's continue on and return to the **index_original.php** file, and take a look at the code we used there to list all the contents in our database. 
In this file, we used a variable for every field, **$name**, **$address**, etc... and then we would output the result using an echo statement.
While that worked great, it's not going to work within a Smarty template - we're going to need to do it differently.
The way we're going to do this is by storing our result in a single variable, which then gets assigned to a Smarty variable. This is where the beauty of arrays come into play - we're going to create an array called $client that will store all info for each of our users.
Open up **index.php** and replace our existing code with this:

```php
<?php
    // This file contains all of the information XOOPS needs to work (like the database information). It's the bootstrap of XOOPS, basicly.
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
    // Specify what template to use
    $xoopsOption['template_main'] = 'people_main.html';
    // This file contains the header and layout of our XOOPS website.
    require_once XOOPS_ROOT_PATH . '/header.php';
    $personData = personLoader();
    $xoopsTpl->assign('person', $personData);
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
            $client[$i]['name']         =   $myRow['name'];
            $client[$i]['address']      =   $myRow['address'];
            $client[$i]['telephone']    =   $myRow['telephone'];
            $client[$i]['email']        =   $myRow['email'];
            // Let's add one to the counter
            $i++;
        }
        // Let's return our array.
        return $client;
    }
    // This file contains the footer, which contains scripts and closes our layout.
    require_once XOOPS_ROOT_PATH . '/footer.php';
?>
```
There are a couple of new things here, for example we're using functions for the first time! Functions are great when you have a piece of code that will be used more than once and it also helps with keeping things cleaner to read.
In this case, we've created a function called personLoader that goes to the database, load up all the info and then returns in the form of an array.

But let's take a closer look at what happens inside our function:

```php
function personLoader(){
    global $xoopsDB;```

The first line creates our function, in this case personLoader, while the second line declares $xoopsDB as a global. If you declare a variable such as $mytest on your page, you won't be able to call it from inside a function. You will need to declare it as global to access it from inside the function, which is the case.
In other words: you can only call variables that are declared global (everywhere) or are declared inside of the function.

```php
    $client = array();
    $i = 1;```

It's a good practice to declare a variable as an array before you start putting data into it. The second line, **$i**, is a helper that we're going to use later on. I'll explain what it is used for later on.

```php
    $query = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix(basename(__DIR__).'_myform'));
    while($myRow = $xoopsDB->fetchArray($query) )
    {
        $client[$i]['name'] = $myRow['name'];
        $client[$i]['address'] = $myRow['address'];
        $client[$i]['telephone'] = $myRow['telephone'];
        $client[$i]['email'] = $myRow['email'];
        // Let's add one to the counter
        $i++;
    }
```
The first line here sets up the query that we will unleash upon our database: it will select all the information from our table.
The second line is a while loop, which will loop through our database results and will load all information we get into our array, and we will use $i as our key.
So, the first time we run our while, $i will be 1 and we will load the name of our user, address, telephone and email into $client\[1\]\['name'\], etc.
If we want to get the information about or 1st result, we can use **$client[1]['name']** or for our fifth one we would use **$client[5]['email']**.

```php
return $client;
}```

After it's finished getting all the info, the function will return the array **$client**. You also need to place a closing bracket to close the function. Now back to our assign:

```php
$personData = personLoader();
$xoopsTpl->assign('persons', $personData);```
```
Here we create a variable called $personData which is then assigned to a Smarty variable called client. This takes care of everything we need to do on the PHP side, so we can now focus on setting up our Smarty template to receive this info.

```php
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><{$smarty.const.PP_NAME}></td>
        <td><{$smarty.const.PP_ADDRESS}></td>
        <td><{$smarty.const.PP_TELEPHONE}></td>
        <td><{$smarty.const.PP_EMAIL}></td>
    </tr>
    <{foreach item = person from = $persons}>
        <tr>
            <td><{$person.name}></td>
            <td><{$person.address}></td>
            <td><{$person.telephone}></td>
            <td><{$person.email}></td>
        </tr>
    <{/foreach}>
</table>
```
Here we're using a foreach loop to iterate through each client. Each client adds a row to our table, which is how we want it to be.

Click on tutorial in the main menu. If you haven't gone through chapter 1 with me, you might not have the database information - so re-install your module if you haven't followed along.