<?php 
//Admin

include_once '../includes/helpers.inc.php';

?>
<!DOCTYPE html>
<html lang= "en">
	<head>
		<meta charset="utf-8">
		<title>Manage Ideas: Search Results</title>
		</head>
	<body>

    <header>
    <button class="home"> <a href="http://greforum.infinityfreeapp.com/admin">Home</a>
   </button>    
    </header>

        <h1>Search Results</h1>
        <?php if (isset($ideas)): ?>
        <table border="1px">
            <tr><th>Idea Text</th><th>Image</th><th>Idea Date</th><th>Author</th><th>Total Votes</th><th>Options</th><th>Comment</th></tr>
            <?php foreach ($ideas as $Idea): ?>
            <tr>
            <td><center><?php echo($Idea['text']);?></center></td>
            <td><center><img src="../img/<?php echo htmlspecialchars($Idea['Image']);?>" style="width:100px;height:100px;"/></center></td>
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
        <p><a href="?">New Search</a></p>
        <?php include_once '../logout.inc.html.php';?>
        <p><a href="..">Return to CMS home</a></p>
	</body>
	</html>