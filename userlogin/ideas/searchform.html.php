<?php 
//User

include_once '../../admin/includes/helpers.inc.php';

?>
<!DOCTYPE html>
<html lang="en">



<style> 
/*links*/
a:link {color:#030bfc;}
a:visited {color:#0000ff;}
a:hover {color:#0398fc;}

body {
  font-family: Arial, Helvetica, sans-serif;
  font-color: black;
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

<head>
<h1>All Ideas</h1>
</head>
    <meta charset="utf-8">
    <title>All Ideas</title>

<body>

<header>
   <!-- <button class="home"> <a href="http://greforum.infinityfreeapp.com/">Home</a>
   </button> -->   
</header>



<form action="" method="get">
<p>Advanced Search</p>
 <p>View ideas satisfying the following criteria or <a href="../?add">Add new idea,</a> otherwise, you can <a href="../?">Manage Your Ideas</a> </p> 
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
   
<?php if (isset($ideas)): ?>
        <table border="1px">
            <tr><th>Idea Text</th><th>Image</th><th>Idea Date</th><th>Author</th><th>Document Download</th><th>Total Votes</th><th>Vote</th><th>Comment</th></tr>
            <?php foreach ($ideas as $Idea): ?>
            <tr>
            <td><center><?php echo($Idea['text']);?></center></td>
            <td><img src="../../user/img/<?php echo htmlspecialchars($Idea['Image']);?>" style="width:100px;height:100px;"/></td>
            <td><center><?php html($Idea['IdeaDate']);?></center></td>
            <td><center><?php html($Idea['Name']);?></center></td>
            <td>
            <form action="document.html.php" method="post">          
            <input type="hidden" name="ID" value="<?php echo $Idea['ID']; ?>">
            <center><input type="submit" name="action" value="Download" ></center>
            </form>
            </td>
            <td><center><?php html($Idea['Vote']);?></center></td>
            <td>
            <form action="" method="post">          
                <input type="hidden" name="ID" value="<?php echo $Idea['ID']; ?>">
                <input type="hidden" name="AuthorID" value="<?php echo $_SESSION['aid']; ?>">
                    <input type="submit" name="action" value="Like" >
                    <input type="submit" name="action" value="Dislike" > 
            </form>
            </td>
            <td>
            <form action="comment.html.php" method="post">          
                <input type="hidden" name="ID" value="<?php echo $Idea['ID']; ?>">
                <input type="hidden" name="AuthorID" value="<?php echo $Idea['AuthorID']; ?>">
                <input type="submit" name="action" value="Comment">
            </form>
            
            </td>
               
            </tr>
            <?php endforeach;?>
        </table>

        <?php endif; ?>   
    
<!--<p><a href="../../">Return to CMS home</a></p>-->

<?php include '../logout.inc.html.php';?>
 <br>
        <footer>Created by greforum &copy; Copyright 2020</footer> 
 
</body>
</html>

<?php 
            // <form action="" method="post">          
            //     <input type="hidden" name="ID" value="<?php echo $Idea['ID']; ">
            /// <center><input type="submit" name="action" value="Download" ></center>
            /// </form>
            
?>