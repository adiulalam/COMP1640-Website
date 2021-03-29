<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php html($pageTitle); ?></title>
</head>
<body>
<h1><?php html($pageTitle); ?></h1>
<form action="?<?php html($action);?>" method="post">
<div><br/>
    <br/>
    <label for="text">Type your idea here:</label><br/><br/>
    <textarea id="text" name="text" rows="3" cols="40"><?php html($text); ?></textarea><br/>
    </div>
    <div>
        <label for="Author">Author:</label>
        <select name="Author" id="Author">
        <option value="">Select one</option>
        <?php foreach ($authors as $Author):?>
        <option value="<?php html($Author['ID']); ?>"<?php 
            if ($Author['ID'] == $AuthorID)
            {
                echo ' selected';
            }
            ?>><?php html($Author['Name']); ?></option>
        <?php endforeach; ?>
    </select>
</div>
    <fieldset>
        <legend>Categories:</legend>
        <?php foreach ($categories as $Category): ?>
        <div><label for ="Category<?php html($Category['ID']); ?>">
            <input type="checkbox" name="categories[]"
                   value="<?php html($Category['ID']); ?>"<?php
                   if ($Category['selected'])
                   {
                       echo ' checked';
                   }
                   ?>><?php html($Category['Name']); ?></label></div>
        <?php endforeach; ?>
    </fieldset>
<div>
    <input type="hidden" name="ID" value="<?php html($ID); ?>">
    <input type="submit" value="<?php html($button); ?>">
</div>
</form>
</body>
</html>