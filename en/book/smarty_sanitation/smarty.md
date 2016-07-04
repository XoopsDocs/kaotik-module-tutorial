#### Everybody loves Smarty!
Who doesn't love smarties? Well, I love them. Unfortunately, the Smarty I'm talking about isn't a chocolade-treat covered with a sugar coat... but it's close!

In all our code until now, we have mixed PHP together with HTML, which isn't really that legible. What if there were a solution that would seperate the logic from the layout? Well, I'm glad to say that such a solution exists! Well, there are even multiple solutions for this, but the one XOOPS utilizes is Smarty.

Smarty is a PHP templating engine, which seperates HTML and PHP from eachother. 
I'll show you an example of a Smarty template:
```php
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <title>{$title_text|escape}</title>
</head>

<body> 
    {* This is a comment that won't be visible in the HTML source *}
    {$body_html}
</body><!-- this is a comment that will be seen in the HTML source -->
</html>
```
This is a very basic Smarty layout, which is using PHP but you don't see any PHP.. How does that come? That's because Smarty uses it's own notation for PHP code.
Basicly, everything between {} brackets is "owned" by smarty and will be used by it.

Let's now hop in and let's go refactor our module to use Smarty!