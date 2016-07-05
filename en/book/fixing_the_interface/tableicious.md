#### Tableicious
Until now, our tables have been looking a bit... dull, to say the least. They've been lacking any styling at all and well... things just look bad.

Let's fix our first layout file, called **people_main.html**.

Open it up and add the class **table table-striped** to the table, so it looks like this:
```html
<{$msg}>
<{if $addNew==0}>
    <table class="table"  width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td><a class="btn btn-default" href="index.php?addnew=1">Add new person</a></td>
        </tr>
    </table>
<{/if}>
<{if $addNew==1}>
    <{include file="db:people_form.html"}>
<{/if}>
<table class="table table-striped" width="100%" border="0" cellspacing="0" cellpadding="0">
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

If you load up our module again, it should look a lot better now. This is thanks to the styles that xbootstrap (and Bootstrap itself) gives us.

I have also snuck up a small update here - if you look closely, you should see that the **Add new person** link dissapears when the form is shown - this is a good practice as useless elements should not be visible. Always try to make a clean UI.

Now, there's one other thing in this view that needs a small update, and that's the **Add new person** link. It's a bit... plain, wouldn't you say?

To remedy this, we're going to add the **btn btn-default** to our link. Change ths button like this:

```html
        <td><a class="btn btn-default" href="index.php?addnew=1">Add new person</a></td>
```

Reload your module again, and the button is styled too! It's starting to look good, but once you press *Add new person**, an ugly looking form appears.
Let's fix that!