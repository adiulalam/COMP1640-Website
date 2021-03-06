<?php
 
if(isset($_GET['action']) and $_GET['action']=='search')
{
    include '../includes/db.inc.php';
    
$select = 'SELECT *, Author.Name FROM';
$from = ' Idea INNER JOIN Author ON Idea.AuthorID = Author.Author_ID';
$where = ' WHERE TRUE';
$placeholders = array();
    
if ($_GET['Author'] != '')
{
    $where .=" AND AuthorID = :AuthorID";
    $placeholders[':AuthorID']=$_GET['Author'];
}

if ($_GET['Category'] != '')
{
    $from .= ' INNER JOIN IdeaCategory ON ID= IdeaID';
    $where .= " AND CategoryID = :CategoryID";
    $placeholders[':CategoryID']=$_GET['Category'];
}
    
if ($_GET['text'] != '')
{
    $where .= " AND IdeaText LIKE :IdeaText";
    $placeholders[':IdeaText']= '%' . $_GET['text'] . '%';
}
    
try
{
    $sql = $select . $from . $where;
    $s = $pdo->prepare($sql);
    $s->execute($placeholders);
}
catch (PDOException $e)
{
    $error = 'Error fetching ideas';
    include 'error.html.php';
    exit();
}
foreach ($s as $row)
{
    $ideas[]=array('ID' => $row['ID'], 'text'=>$row['IdeaText'], 'Image'=>$row['Image'], 'IdeaDate'=>$row['IdeaDate'], 'Name'=>$row['Name'], 'Vote'=>$row['Vote'], 'AuthorID' => $row['AuthorID']);
}

include 'ideas.html.php';
exit();
}
///
include '../includes/db.inc.php';
try{
    $result= $pdo->query('SELECT Author_ID, Name FROM Author');
}
catch (PDOException $e)
{
    $error = 'Error fetching authors from the database';
    include 'error.html.php';
    exit();
}

foreach ($result as $row)
   {
       $authors[]=array('ID' => $row['Author_ID'], 'Name'=>$row['Name']);
   }

try{
    $result= $pdo->query('SELECT ID, Name FROM Category');
}
catch (PDOException $e)
{
    $error = 'Error fetching categories from the database';
    include 'error.html.php';
    exit();
}

foreach ($result as $row)
   {
       $categories[]=array('ID' => $row['ID'], 'Name'=>$row['Name']);
   }

try
{
    $sql = 'SELECT *, Author.Name FROM Idea INNER JOIN Author ON Idea.AuthorID = Author.Author_ID';


    $s = $pdo->prepare($sql);
    $s->execute(array());
}
catch (PDOException $e)
{
    $error = 'Error fetching ideas';
    include 'error.html.php';
    exit();
}
foreach ($s as $row)
{
    $ideas[]=array('ID' => $row['ID'], 'text'=>$row['IdeaText'], 'Image'=>$row['Image'], 'IdeaDate'=>$row['IdeaDate'], 'Name'=>$row['Name'], 'Vote'=>$row['Vote']);
    $Vote = $row['Vote'];

}

include 'searchform.html.php';




?>