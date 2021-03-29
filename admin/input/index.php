<?php
//error_reporting(0);

if (isset($_GET['addidea']))
{
    include 'form.html.php';
    exit();
}

if (isset($_POST['IdeaText']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'INSERT INTO Idea SET
            IdeaText = :IdeaText,
            IdeaDate= CURDATE()';
        $s=$pdo->prepare($sql);
        $s->bindValue(':IdeaText', $_POST['IdeaText']);
        $s->execute();
    }

catch (PDOException $e)
{
    $error = 'Error adding submitted idea' . $e->getMessage();
    include 'error.html.php';
    exit();
}
header('Location: .');
exit();
}

if(isset($_GET['deleteidea']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'DELETE FROM Idea WHERE ID = :ID';
        $s =$pdo->prepare($sql);
        $s->bindValue(':ID', $_POST['ID']);
        $s->execute();
    }

catch (PDOException $e)
{
    $error = 'Error deleting idea' . $e->getMessage();
    include 'error.html.php';
    exit();
}
header('Location: .');
exit();
}

try
{
    $pdo= new PDO('mysql:host=mysql.cms.gre.ac.uk;dbname=mdb_aa6932u', 'aa6932u', 'aa6932u');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
}
catch(PDOException $e)
{
    $error= 'Unable to connect to database server:' . $e->getMessage();
    //$error= 'Unable to connect to database server:';
    include 'error.html.php';
    exit();
}

include '../includes/db.inc.php';
try 
{
    $sql= 'SELECT Idea.ID, IdeaText, IdeaDate, Name, Email 
    FROM Idea INNER JOIN Author 
    ON AuthorID = Author_ID';
    $result=$pdo->query($sql);
}
catch (PDOException $e)
{
    $error= 'Error fetching ideas' . $e->getMessage();
    include 'error.html.php';
    exit();
}

foreach($result as $row)
{
    $ideas[]= array(
    'ID'=> $row['ID'],
    'IdeaText'=> $row['IdeaText'],
    'IdeaDate'=> $row['IdeaDate'],
    'Name'=> $row['Name'],
    'Email'=>$row['Email']
    );
}
include 'ideas.html.php';

//$error= 'Database connection established';
//include 'error.html.php';

?>