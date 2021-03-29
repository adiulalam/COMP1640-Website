<?php
include '../includes/db.inc.php';

    try
    {

    $sql = 'SELECT Comment FROM Comment INNER JOIN Idea ON Comment.IdeaID = Idea.ID WHERE Idea.ID = :ID;';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
    }

        catch (PDOException $e)
    {
        $error = 'Error getting Comment';
        include 'error.html.php';
        exit();
    }


    foreach ($s as $row)
    {

    $comments[]=array('ID' => $row['ID'], 'Comment'=>$row['Comment']);
    
    }
    $ID =  $_POST['ID'];
     

    if (isset($_POST['Comment'])) {
    // Escape any html characters


    try
    {

    $sql = 'INSERT INTO Comment SET Comment = :Comment, IdeaID= :IdeaID;';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':Comment', $_POST['Comment']);
    $s->bindvalue(':IdeaID', $_POST['ID']);
    $s->execute();
    }

        catch (PDOException $e)
    {
        $error = 'Error inserting Comment';
        include 'error.html.php';
        exit();
    }

header('Location: .');
exit();

    
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Comments</title>
</head>
<body>

<?php if (isset($comments)): ?>
        <table border="1px">
            <tr><th>Comments</th></tr>
            <?php foreach ($comments as $Comment): ?>
            <tr>
            <td><center><?php echo($Comment['Comment']);?></center></td>
               
            </tr>
            <?php endforeach;?>
        </table>
<?php endif; ?>  

    <form method="post" action="?">

    <label for="text">Type your Comment here:</label><br/>
    <textarea id="Comment" name="Comment" rows="10" cols="40"></textarea>


    <input type="hidden" name="ID" value="<?php echo($ID); ?>">
    <input type="submit" name="submit" value="Send" />
    </form>
    
<p><a href="../../">Return to CMS home</a></p>
    


</body>
</html>


