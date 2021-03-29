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
/*links*/
a:link {color:#ff0000;}
a:visited {color:#0000ff;}
a:hover {color:#0398fc;}
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
    <title>Manage Ideas</title>
</head>
<body>
<h1>Manage Your Ideas</h1>


<!--<p><a href="?add">Add new idea</a></p>-->
<form action="" method="get">
<p>View ideas satisfying the following criteria, <a href="ideas/index.php">See all Ideas</a> or <a href="?add">Add new idea</a> </p>
    <input type="hidden" name="Author" value="<?php html($_SESSION['aid']); ?>">
<div>
    <label for="Category">By Category:</label>
    <select Name="Category" ID="Category">
        <option value="">Any Category</option>
        <?php foreach ($categories as $Category):?>
        <option value="<?php html($Category['ID']); ?>"><?php html($Category['Name']);?></option>
        <?php endforeach; ?>
    </select>
</div> <br>
    
<div>
    <label for="text">Containing text</label>
    <input type="text" name="text" id="text"> 
</div>
    
<div><br>
    <input type="hidden" name="action" value="search">
    <input type="submit" value="search"> 

</div>

</form>

<br>
<!--<form action="ideas/index.php" method="post">          
    <input type="submit" name="action" value="See All Idea">
</form>  

<!--<p><a href="../../">Return to CMS home</a></p>-->
<?php include 'logout.inc.html.php';?>

</body>
<footer>Created by greforum &copy; Copyright 2020</footer> 
</html>