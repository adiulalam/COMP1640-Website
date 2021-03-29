<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang= "en">
	<head>
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
label {
    font-weight: bold;
}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 4px;
  
}

input[type=submit], [type=reset]  {
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

input[type=reset]:hover {
  opacity:15;
}

a {
  color: dodgerblue;
}
/* styling for footer */
footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #e3ecff;
   color: #8d9ab8;
   text-align: center;
}
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
 </style>
		<meta charset="utf-8">
		<title>Manage Ideas: Search Results</title>
		</head>
	<body>
    <ul>
  <li><a href="../../#home">Home</a></li>
  <li><a href="../../user/aboutus/">About Us</a></li>
  <li style="float:right"><a href="../../user/adminmail/">Contact Us</a></li>
  <li><a href="../../reg">Register<br></a><li>
  <li><a href="../../userlogin">Login<br></a><li>
</ul>
        <h1>Search Results</h1>
        <?php if (isset($ideas)): ?>
        <table border="1px">
            <tr><th>Idea Text</th><th>Image</th><th>Idea Date</th><th>Author</th><th>Total Votes</th></tr>
            <?php foreach ($ideas as $Idea): ?>
            <tr>
            <td><center><?php echo($Idea['text']);?></center></td>
            <td><center><img src="../img/<?php echo htmlspecialchars($Idea['Image']);?>" style="width:100px;height:100px;"/></center></td>
            <td><center><?php html($Idea['IdeaDate']);?></center></td>
            <td><center><?php html($Idea['Name']);?></center></td>
            <td><center><?php html($Idea['Vote']);?></center></td>
            </tr>
            <?php endforeach;?>
        </table>
        <?php endif; ?>
        <p><a href="?">New Search</a></p>
        <p><a href="../ideas/">Return to CMS home</a></p>
	</body>
	</html>