<?php include_once '../admin/includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang= "en">

	<head>
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
/*styling for buttons*/
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
/*links*/
a:link {color:#030bfc;}
a:visited {color:#0000ff;}
a:hover {color:#0398fc;}

    </style>
		<meta charset="utf-8">
		<title>Manage Ideas: Search Results</title>
		</head>
	<body>
        <h1>Search Results - Your Ideas</h1>
        <p>View your ideas below or to filter through your ideas select <a href="?">Manage My Ideas</a> or you can <a href="?add">Add new idea,</a> otherwise, <a href="ideas/index.php">See all Ideas.</a></p>
        <!--<p>View ideas satisfying the following criteria, <a href="../ideas/index.php">See all Ideas</a> or <a href="../?add">Add new idea.</a> </p>-->
        <?php if (isset($ideas)): ?>
        <table border="1px">
            <tr><th>Idea Text</th><th>Image</th><th>Idea Date</th><th>Author</th><th>Total Votes</th><th>Options</th></tr>
            <?php foreach ($ideas as $Idea): ?>
            <tr>
            <td><center><?php echo($Idea['text']);?></center></td>
            <td><center><img src="../user/img/<?php echo htmlspecialchars($Idea['Image']);?>" style="width:100px;height:100px;"/></center></td>
            <td><center><?php html($Idea['IdeaDate']);?></center></td>
            <td><center><?php html($Idea['Name']);?></center></td>
            <td><center><?php html($Idea['Vote']);?></center></td>
            <td>
            <form action="?" method="post">          
                <input type="hidden" name="ID" value="<?php echo $Idea['ID']; ?>">
                    <input type="submit" name="action" value="Edit">
                    <input type="submit" name="action" value="Delete">
            </form>   
            </td>  
            </tr>
            <?php endforeach;?>
        </table>
        <?php endif; ?>
       <!-- <p><a href="?">New Search</a></p>-->
        <?php include_once '../logout.inc.html.php';?>
        <p><a href="..">Return to CMS home</a></p>
         <footer>Created by greforum &copy; Copyright 2020</footer> 
	</body>
	</html>