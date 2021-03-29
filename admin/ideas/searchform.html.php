<?php 
//Admin

include_once '../includes/helpers.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Manage Ideas</title>
</head>
<body>

<header>
    <button class="home"> <a href="http://greforum.infinityfreeapp.com/admin">Home</a>
   </button>    
</header>

<h1>Manage Ideas</h1>
<!-- <p><a href="?add">Add new idea</a></p> -->
<form action="" method="get">
<p>View ideas satisfying the following criteria</p>
<div>
    <label for="Author">By Author:</label>
    <select Name="Author" ID="Author">
        <option value="">Any Author</option>
        <?php foreach ($authors as $Author):?>
        <option value="<?php html($Author['ID']); ?>"><?php html($Author['Name']);?></option>
        <?php endforeach; ?>
    </select>
</div>
    
<div>
    <label for="Category">By Category:</label>
    <select Name="Category" ID="Category">
        <option value="">Any Category</option>
        <?php foreach ($categories as $Category):?>
        <option value="<?php html($Category['ID']); ?>"><?php html($Category['Name']);?></option>
        <?php endforeach; ?>
    </select>
</div>
    
<div>
    <label for="text">Containing text</label>
    <input type="text" name="text" id="text">
</div>
    
<div>
    <input type="hidden" name="action" value="search">
    <input type="submit" value="search">
</div>
    
</form>
<p><a href="..">Return to CMS home</a></p>
    
</body>
</html>