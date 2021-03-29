<?php include_once '../admin/includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
/*page font*/
body {
  font-family: Arial, Helvetica, sans-serif;
  font-color: black;
}
/* styling for form */
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=submit] {
 background-color: #5983ff;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
  font-size: 20px;
}
input[type=submit]:hover {
  opacity:15;
}
div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
/*links*/
a:link {color:#030bfc;}
a:visited {color:#0000ff;}
a:hover {color:#0398fc;}

/*footer styling*/
footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #e3ecff;
   color: #8d9ab8;
   text-align: center;
}
</style>


    <meta charset="utf-8">
    <title><?php html($pageTitle); ?></title>
</head>
<body>
<h1><?php html($pageTitle); ?></h1>
<p>Return to <a href="ideas/index.php">See all Ideas</a> or you can <a href="?">Manage Your Ideas.</a> </p>
<form action="?<?php html($action);?>" method="post" enctype="multipart/form-data">
<div>
 
    <label for="text">Type your idea here:</label><br/>
    <textarea id="text" name="text" rows="3" cols="40"><?php html($text); ?></textarea>
    </div>
    <input type="hidden" name="Author" value="<?php html($_SESSION['aid']); ?>">
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

        <fieldset>
        <legend>Departments:</legend>
        <?php foreach ($departments as $Department): ?>
        <div><label for ="Department<?php html($Department['ID']); ?>">
            <input type="checkbox" name="departments[]"
                   value="<?php html($Department['ID']); ?>"<?php
                   if ($Department['selected'])
                   {
                       echo ' checked';
                   }
                   ?>><?php html($Department['Name']); ?></label></div>
        <?php endforeach; ?>
    </fieldset>

    <div><br/>
         <label for="Email">Department’s QA Coordinator Email: <input type="text" name="Email"></label>
    </div><br/>

        <div><br/>
         <input type="file" name="myfile" value="Upload"> 
    </div><br/>
    
<div>
    <input type="hidden" name="ID" value="<?php html($ID); ?>">
    <input type="submit" value="<?php html($button); ?>">
    
   
</div>
 
</form>
</form>
<br>
<footer>Created by greforum &copy; Copyright 2020</footer> 
</body>
</html>