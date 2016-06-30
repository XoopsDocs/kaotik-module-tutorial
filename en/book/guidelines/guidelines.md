#### Guidelines
In this document, we're going over several tips and hints that will help you when you first start coding a module. Even experienced developers can learn from these or perhaps even still use these! So, be sure to at least think about these.

##### Prepare yourself before you code
Before you start working on a module, define for yourself what it should do first. If you start with clear objectives, it's becomes a lot easier to resolve them.
If you start writing code without first defining what your module should do, it's easy to miss things and you might even have to rewrite entire parts of your code because you didn't keep things in mind. Try to avoid that by planning out ahead!

Never start a module with directly coding - if you do, you will be limiting the module to what you already know in terms of code instead of what it should accomplish.
A good example of this is writing themes for XOOPS, where you often use a default template. If you start hacking away at a default template, you're already limiting yourself to the choices made in the default template that might be hard to change.

#### Properly indent your code
There are quite a lot of conventions and one of them is to indent your code. Unindented code is a nightmare to work in and is very hard to understand.
If you properly indent your code, you'll make your life a lot easier as well as the life of many people around you.

##### Template aesthetics vs. functionality
As you get better at PHP and XOOPS development, you'll find that you are cramming more and more functionality into templates, making use of more and more <{if}> statements. This is a mistake, as the whole point of using Smarty (XOOPS it's templating engine) is to visually arrange HTML code without having PHP in it. If you open a smarty template in a WYSIWYG and if you can't understand what's going on, then you already have too much going on inside it.

So, how do I give users options without overloading the templates? With help-files - show users the available options they can use inside the templates. For example: you have an article. Instead of having a XOOPS Preference for each individual item such as article date, name, title, publisher, etc, create a simple base template and then show your users which options are available inscase they want to add more info to that template:
```php
<{$art.title}>,<{$art.date}>,<{$art.name}>,<{$art.publisher}>,
```
etc.

##### MVC
An often used pattern in PHP is MVC, which stands for Model, View, Controller and simply said this means that you seperate all database logic, all application logic and all views (layout) from each other. This promotes creating re-usable code, as well as making your module easier to maintain.

More information about MVC is available on the internet, but when you create a XOOPS module it's preferred to seperate all logic from each other. 

##### Server load
Try to minimize the number of times your module has to access the database. One common mistake is to create database quaries inside of loops, which is a BIG mistake. This leads to a lot of (avoidable) queries.
If you need to select all articles, do so in a single query, and don't select just 1 article at a time.

As your modules grow, so will the number of queries. Try to make them as efficient as you can!

##### One to many - database relationships
To explain this I'll use an example: let's suppose you have a database table with the following information about your clients:

**table_client**

|ID|name|telephone|email|
|-|-|-|-|
|12|john anton|23465544|john11q@johhny.com|
|13|ric senten|32144323|senten2333@yahoo.com|

Now, what if I wanted to add more phone numbers for each client? Your first thought might be to create an array and store that in the table. It won't work because your data will no longer be understandable using PhpMyAdmin. What about a comma separated string? well, if you were to do this: "2324335,2329786" what would happen if your user only filled in the last phone number? How would you tell which phone number was the home number and which was the mobile? The solution is called a "one to many" relationship. We create another table that will hold our phone numbers:

**table_client**

|ID|name|email|
|-|-|-|
|12|john anton|john11q@johhny.com|
|13|ric senten|senten2333@yahoo.com|

**table_client_phones**

|ID|table_client_id|phone_type|phone_number|
|-|-|-|-|
|1|12|home|2346554|
|2|12|mobile|7851232|
|3|12|office|4576598|
|4|13|home|1253654|
|5|13|mobile|8786521|

So now, when we want the phone numbers for "john anton" we just do a query on

```php
table_client_phones where table_client_id is equal to '12'. 
```

If we wanted a specific type of phone, for example the mobile we could build a query like this: 

```php
" WHERE table_client_id='12' AND phone_type='mobile' ".
```

##### Feature Creep
When you finally publish your first module, lots of feature requests will start coming from your users. Before you even consider those new features consider these points:
* Are the current features stable? Does it work across different platforms such as servers running on Linux or Windows. Is it browser compatible? 
* Does it run on all database systems?
* Will my module lose its focus with these new features? Your module had a clear purpose when it started, don’t lose it. Make it good at that one objective. Many times developers try to create a module that’s too generic, meaning the module might be satisfactory at many different jobs but not particularly good at any in particular.
* Does this new feature benefit the majority? This might sound mean, but when adding new features, the ones that will benefit the majority should take priority. There’s no point wasting your valuable time on a feature that will be used by only 2 or 3 users.
* Does the feature match with my module? It's possible that a feature is too far-stretched to be used in your module and belongs in a seperate module.
* Budget your time. As most developers you probably have limited time to dedicate to your XOOPS module(s). Your family, job or other responsabilities will always come first, so, plan for feasable goals.
* Release often. It’s better to make small changes and release a new version then have your users wait months on end for a new “super” version.
* Be open about development/put your source code on GitHub or another coding platform. This way, others can contribute to your modules as well.
* Test then release. Always test your module on different platforms before releasing it. As your module gets popular, people will volunteer to test it. Use them!
* If possible, try to use unit-tests.
* Keep a clear upgrade path. You’ve created a popular module, version 1.0. Lots of people are using it. They have invested time to personalize it to their needs and have inserted lots of info into it. So your first priority with a new version should be towards these users. They are already supporting you by using this module.

##### Structured Code
When creating a new module, I plan all classes on paper first, drawing diagrams of how the classes and functions should interact with each other. This allows me to understand dependencies and how the module should work before writing a single line of code. Even a little planning for your module will save you a lot of problems latter on when writing functions.

If needed, you can also write complete diagrams of your application which shows you the complete structure of your module.

##### Comment your code
The best way to comment your code is to write the comment immediately after you create or change a function or class. I know some developers write their comments at the very end of their development cycle. This in my opinion is a mistake. It’s easier to write 1 or 2 lines of comments for the function you just wrote then to have to write 100 lines of comments for functions you don’t even remember you had.

##### Document your module
Don't depend on others for documentation about your module - provide it yourself. This way, it's easier for others to use your module.
Advanced features should be explained well, or be made less advanced.

##### Keep users informed
Users that install and use your module will want to know how its development is progressing. Even if you can’t budget time for your module, let them know. It’s better to tell your users “I can’t code for 4 to 8 weeks” then to leave them in the dark regarding module progress. Remember: your module is only usefull if people actually use it. So, keep them happy.

##### Search for answers
Don't be afraid to use xoops.org or to ask questions - chances are the problem you're facing has been dealt with before. If you can't find it, don't hesitate to ask, as many developers will be happy to help.

##### Develop with Vagrant
If you're not developing locally yet, a great way to do so is by using Vagrant in combination with a PHP vagrant box. If this goes too far for you, you can install a Wamp solution like xampp, wamp or wampserver.

##### Use modern techniques and code
Don't use code that gives you errors, is outdated or simply doesn't work well at all - there's a reason why they generate errors.
If you get an error, try to find a solution or handle it another way.
