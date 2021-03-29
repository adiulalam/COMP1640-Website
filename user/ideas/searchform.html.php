<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
<!--NEW CODE-->
<ul>
  <li><a href="../../#home">Home</a></li>
  <li><a href="../../user/aboutus/">About Us</a></li>
  <li style="float:right"><a href="../../user/adminmail/">Contact Us</a></li>
  <li><a href="../../reg">Register<br></a><li>
  <li><a href="../../userlogin">Login<br></a><li>
</ul>

<style> 
body {
  font-family: Arial, Helvetica, sans-serif;
  font-color: black;
}
   /* styling for navigation bar */
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}
li {
  float: left;
  border-right:2px solid #fafcff;
}
li:last-child {
  border-right: none;
}
li a {
  display: block;
  color: white;
  text-align: center;
  padding: 23px 36px;
  text-decoration: none;
}
li a:hover:not(.active) {
  background-color: #5983ff;
}
.active {
  background-color: #a1c0ff;
}

#home {
  left: 0px;
  width: 46px;
  background: url('img_navsprites.gif') 0 0;
}

footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #e3ecff;
   color: #8d9ab8;
   text-align: center;
}

/*p {
  text-align: center;
  margin: 150px;
}*/

/* styling for table */
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {background-color: #f2f2f2;}

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

</style>




    <meta charset="utf-8">
    <title>All Ideas</title>
</head>
<body>

<!--<header>
    <button class="home"> <a href="http://greforum.infinityfreeapp.com/">Home</a>
   </button>    
</header>-->

<h1>All Ideas</h1>

<form action="" method="get">
<p>Advanced Search</p>
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
    
</form> <br>
   
<?php if (isset($ideas)): ?>
        <table style="overflow-x:auto;" border="1px">
            <tr><th>Idea Text</th><th>Image</th><th>Idea Date</th><th>Author</th><th>Total Votes</th><th>Vote</th><th>Comment</th></tr>
            <?php foreach ($ideas as $Idea): ?>
            <tr>
            <td><center><?php echo($Idea['text']);?></center></td>
            <td><img src="../img/<?php echo htmlspecialchars($Idea['Image']);?>" style="width:100px;height:100px;"/></td>
            <td><center><?php html($Idea['IdeaDate']);?></center></td>
            <td><center><?php html($Idea['Name']);?></center></td>
            <td><center><?php html($Idea['Vote']);?></center></td>
            <td>
            <form action="../../userlogin" method="post">          
                    <input type="submit" name="action" value="Login To vote"> 
            </form>
            </td>
            <td>
            <form action="../../userlogin" method="post">          
                    <input type="submit" name="action" value="Login To Comment">
            </form>
            </td>
               
            </tr>
            <?php endforeach;?>
        </table> <br>
        <?php endif; ?>   

<!--<p><a href="../../">Return to CMS home</a></p>-->
   <footer>Created by greforum &copy; Copyright 2020</footer> 
</body>
</html>