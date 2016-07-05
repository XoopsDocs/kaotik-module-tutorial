#### Forming the form
Okay, we're finished with **people_main.html** for now - now it's time to start working on our form so it looks good.
Open up **people_form.html** and we'll get started right away.

We're going to transform our form into an inline form, and we're going to throw all tables out - tables are a relic of the past and **should only be used for displaying tabular data**.
That's what they're really good for - layouting? Not so much.

After reworking the form, the code for **people_main.html** should be this:
```html
<form class="form-horizontal" name="people_form" method="post" action="index.php">
    <fieldset class="form-group">
    <div class="form-group">
        <label for="name"><{$smarty.const.PP_NAME}></label>
        <input type="text" class="form-control" name="name" placeholder="<{$smarty.const.PP_NAME}>">
    </div>
    <div class="form-group">
        <label for="name"><{$smarty.const.PP_ADDRESS}></label>
        <input type="text" class="form-control" name="address" placeholder="<{$smarty.const.PP_ADDRESS}>">
    </div>
    <div class="form-group">
        <label for="name"><{$smarty.const.PP_TELEPHONE}></label>
        <input type="text" class="form-control" name="telephone" placeholder="<{$smarty.const.PP_TELEPHONE}>">
    </div>
    <div class="form-group">
        <label for="name"><{$smarty.const.PP_EMAIL}></label>
        <input type="text" class="form-control" name="email" placeholder="<{$smarty.const.PP_EMAIL}>">
    </div>
    <button class="btn btn-default" type="submit" name="listAll" value="List All">List all inputs</button>
    <button class="btn btn-success" type="submit" name="submit" value="submit">Submit</button>
    </fieldset>
</form>
```

And with this, our module has become a lot more presentable! There's one more thing though...