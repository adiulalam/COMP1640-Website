<?php

    
include '../includes/db.inc.php';

try{
    $result= $pdo->query('SELECT *, Author.Name FROM Idea INNER JOIN Author ON Idea.AuthorID = Author.Author_ID'); //selects everything from database
}

catch (PDOException $e)
{
    $error = 'Error fetching idea from the database';
    include 'error.html.php';
    exit();
}


foreach ($result as $row) //makes everything a variable
   {
       $ideas[]=array('ID' => $row['ID'], 'text'=>$row['IdeaText'], 'IdeaDate'=>$row['IdeaDate'], 'Ingredients'=>$row['Ingredients'], 'PrepMethod'=>$row['PrepMethod'], 'PrepTime'=>$row['PrepTime'], 'CookTime'=>$row['CookTime'],'Serving'=>$row['Serving'],'Ref'=>$row['Ref'], 'Name'=>$row['Name']);
    
   }

include 'details.html.php';
?>