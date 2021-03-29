<?php include_once '../../admin/includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang= "en">
<style>
/*page font*/
body {
  font-family: Arial, Helvetica, sans-serif;
  font-color: black;
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
 /* styling for navigation bar */
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  /*background-color: #333;*/
  background-color: pink;
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
  /*background-color: #5983ff;*/
  background-color: white;
}
.active {
  background-color: #a1c0ff;
}

#home {
  left: 0px;
  width: 46px;
  background: url('img_navsprites.gif') 0 0;
}
</style>

	<head>
		<meta charset="utf-8">
		<title>Manage Ideas: Search Results</title>


		</head>
	<body>
        <h1>Search Results</h1>
        <p>View the ideas below or to filter through the ideas conduct a <a href="?">New Search</a> or <a href="../?add">Add new idea</a> or <a href="../?">Manage Your Ideas.</a></p>
       <!-- <p>View ideas satisfying the following criteria, <a href="../ideas/index.php">See all Ideas</a> or <a href="../?add">Add new idea</a> </p>-->
        <?php if (isset($ideas)): ?>
        <table border="1px">
            <tr><th>Idea Text</th><th>Image</th><th>Idea Date</th><th>Author</th><th>Total Votes</th></tr>
            <?php foreach ($ideas as $Idea): ?>
            <tr>
            <td><center><?php echo($Idea['text']);?></center></td>
            <td><center><img src="../../user/img/<?php echo htmlspecialchars($Idea['Image']);?>" style="width:100px;height:100px;"/></center></td>
            <td><center><?php html($Idea['IdeaDate']);?></center></td>
            <td><center><?php html($Idea['Name']);?></center></td>
            <td><center><?php html($Idea['Vote']);?></center></td>
            </tr>
            <?php endforeach;?>
        </table> <br>
        <?php endif; ?>
        <!--<p><a href="?">New Search</a></p>
        <p><a href="../ideas/">Return to CMS home</a></p>-->
        <?php include '../logout.inc.html.php';?>
        <br>
        <footer>Created by greforum &copy; Copyright 2020</footer> 
	</body>
	</html>









