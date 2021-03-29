<?php

error_reporting(0);
require_once '../../admin/includes/access.inc.php';



if (!userIsLoggedIn()){ 
    include '../login.html.php'; 
    exit();
} 
customer();

if (!userHasRole('User'))
{
    $error='Only signed up users may access this page.';
    include '../../admin/accessdenied.html.php'; 
    exit(); 
}




if(isset($_GET['action']) and $_GET['action']=='search')
{
    include '../../admin/includes/db.inc.php';
    
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
include '../../admin/includes/db.inc.php';

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



///
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
////
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
    $ideas[]=array('ID' => $row['ID'], 'text'=>$row['IdeaText'], 'Image'=>$row['Image'], 'IdeaDate'=>$row['IdeaDate'], 'Name'=>$row['Name'], 'Vote'=>$row['Vote'], 'AuthorID' => $row['AuthorID']);
    $Vote = $row['Vote'];

}




include 'searchform.html.php';

/*****************************************************/
//vote
//////// new
    include '../../admin/includes/db.inc.php';

// vote
    try
    {

    $sql = 'SELECT Vote from Idea WHERE ID = :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();

        }
catch (PDOException $e)
{
    $error = 'Error getting Idea statistics';
    include 'error.html.php';
    exit();
}

    foreach ($s as $row)
{
    $vote = $row["Vote"];
}


///button click
if(isset($_POST['action']) and $_POST['action']=='Upvote')
    {

        $IdeaID = $_POST['ID'];
        $AuthorID = $_POST['AuthorID'];
    
    ///insert
    try
    {
        $sql = "INSERT INTO Vote (IdeaID, AuthorID) SELECT * FROM (SELECT '$IdeaID', '$AuthorID') AS tmp WHERE NOT EXISTS (SELECT * FROM Vote WHERE IdeaID = '$IdeaID' AND AuthorID = '$AuthorID') LIMIT 1;";
        $s =$pdo->prepare($sql);
        $s->execute();
        
    }
    
    catch (PDOException $e)
    {
        $error = 'Error Inserting Vote from vote table';
        include 'error.html.php';
        exit();
    }

    ///select
    try
    {

        $sql = 'SELECT VoteNumber from Vote WHERE IdeaID = :ID AND AuthorID = :AuthorID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':AuthorID', $_POST['AuthorID']);
        $s->execute();

    }
    catch (PDOException $e)
    {
        $error = 'Error getting Vote ';
        include 'error.html.php';
        exit();
    }

        foreach ($s as $row)
    {
        $votenumber = $row["VoteNumber"];
    }

    $vote += 1 ;
    

    $secondsWait = 0.1;

    ///..////if votenumber = 0 -----
    if ($votenumber == 0){

    $votenumber += 1 ;

    /// Update idea vote
    try
    {
        $sql = "UPDATE Idea SET Vote = :Vote WHERE ID = :ID "; 
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':Vote', $vote);
        $s->execute();
    }

    
    catch (PDOException $e)
    {
        $error = 'Error updating vote in Idea';
        include 'error.html.php';
        exit();
    }

    ///update Vote
        try
    {
        $sql = "UPDATE Vote SET VoteNumber = :VoteNumber WHERE IdeaID = :IdeaID AND AuthorID = :AuthorID"; 
        $s =$pdo->prepare($sql);
        $s->bindvalue(':IdeaID', $_POST['ID']);
        $s->bindvalue(':AuthorID', $_POST['AuthorID']);
        $s->bindvalue(':VoteNumber', $votenumber);
        $s->execute();
    }

    
    catch (PDOException $e)
    {
        $error = 'Error updating vote in Vote';
        include 'error.html.php';
        exit();
    }


    echo date('Y-m-d H:i:s');
    echo '<meta http-equiv="refresh" content="'.$secondsWait.'">';

    exit();
    //./// old end
    }

    //else if vote = -1
    else if ($votenumber == -1){

    $votenumber += 2 ;

    /// Update idea vote
    try
    {
        $sql = "UPDATE Idea SET Vote = :Vote WHERE ID = :ID "; 
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':Vote', $vote);
        $s->execute();
    }

    
    catch (PDOException $e)
    {
        $error = 'Error updating vote in Idea';
        include 'error.html.php';
        exit();
    }

    ///update Vote
        try
    {
        $sql = "UPDATE Vote SET VoteNumber = :VoteNumber WHERE IdeaID = :IdeaID AND AuthorID = :AuthorID"; 
        $s =$pdo->prepare($sql);
        $s->bindvalue(':IdeaID', $_POST['ID']);
        $s->bindvalue(':AuthorID', $_POST['AuthorID']);
        $s->bindvalue(':VoteNumber', $votenumber);
        $s->execute();
    }

    
    catch (PDOException $e)
    {
        $error = 'Error updating vote in Vote';
        include 'error.html.php';
        exit();
    }


    echo date('Y-m-d H:i:s');
    echo '<meta http-equiv="refresh" content="'.$secondsWait.'">';

    exit();
    //./// old end
        
    }

    //vote = 1
    else if ($votenumber == 1){
        echo '<script language="javascript">';
        echo 'alert("You Have Already Upvoted")';
        echo '</script>';

    }


    }

if(isset($_POST['action']) and $_POST['action']=='Downvote')
    {

        $IdeaID = $_POST['ID'];
        $AuthorID = $_POST['AuthorID'];
    
    ///insert
    try
    {
        $sql = "INSERT INTO Vote (IdeaID, AuthorID) SELECT * FROM (SELECT '$IdeaID', '$AuthorID') AS tmp WHERE NOT EXISTS (SELECT * FROM Vote WHERE IdeaID = '$IdeaID' AND AuthorID = '$AuthorID') LIMIT 1;";
        $s =$pdo->prepare($sql);
        $s->execute();
        
    }
    
    catch (PDOException $e)
    {
        $error = 'Error Inserting Vote from vote table';
        include 'error.html.php';
        exit();
    }

    ///select
    try
    {

        $sql = 'SELECT VoteNumber from Vote WHERE IdeaID = :ID AND AuthorID = :AuthorID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':AuthorID', $_POST['AuthorID']);
        $s->execute();

    }
    catch (PDOException $e)
    {
        $error = 'Error getting Vote ';
        include 'error.html.php';
        exit();
    }

        foreach ($s as $row)
    {
        $votenumber = $row["VoteNumber"];
    }

    $vote -= 1 ;
    

    $secondsWait = 0.1;

    ///..////if votenumber = 0 -----
    if ($votenumber == 0){

    $votenumber -= 1 ;

    /// Update idea vote
    try
    {
        $sql = "UPDATE Idea SET Vote = :Vote WHERE ID = :ID "; 
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':Vote', $vote);
        $s->execute();
    }

    
    catch (PDOException $e)
    {
        $error = 'Error updating vote in Idea';
        include 'error.html.php';
        exit();
    }

    ///update Vote
        try
    {
        $sql = "UPDATE Vote SET VoteNumber = :VoteNumber WHERE IdeaID = :IdeaID AND AuthorID = :AuthorID"; 
        $s =$pdo->prepare($sql);
        $s->bindvalue(':IdeaID', $_POST['ID']);
        $s->bindvalue(':AuthorID', $_POST['AuthorID']);
        $s->bindvalue(':VoteNumber', $votenumber);
        $s->execute();
    }

    
    catch (PDOException $e)
    {
        $error = 'Error updating vote in Vote';
        include 'error.html.php';
        exit();
    }


    echo date('Y-m-d H:i:s');
    echo '<meta http-equiv="refresh" content="'.$secondsWait.'">';

    exit();
    //./// old end
    }

    //else if vote = 1
    else if ($votenumber == 1){

    $votenumber -= 2 ;

    /// Update idea vote
    try
    {
        $sql = "UPDATE Idea SET Vote = :Vote WHERE ID = :ID "; 
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':Vote', $vote);
        $s->execute();
    }

    
    catch (PDOException $e)
    {
        $error = 'Error updating vote in Idea';
        include 'error.html.php';
        exit();
    }

    ///update Vote
        try
    {
        $sql = "UPDATE Vote SET VoteNumber = :VoteNumber WHERE IdeaID = :IdeaID AND AuthorID = :AuthorID"; 
        $s =$pdo->prepare($sql);
        $s->bindvalue(':IdeaID', $_POST['ID']);
        $s->bindvalue(':AuthorID', $_POST['AuthorID']);
        $s->bindvalue(':VoteNumber', $votenumber);
        $s->execute();
    }

    
    catch (PDOException $e)
    {
        $error = 'Error updating vote in Vote';
        include 'error.html.php';
        exit();
    }


    echo date('Y-m-d H:i:s');
    echo '<meta http-equiv="refresh" content="'.$secondsWait.'">';

    exit();
    //./// old end
        
    }

    //vote = -1
    else if ($votenumber == -1){
        echo '<script language="javascript">';
        echo 'alert("You Have Already Downvoted")';
        echo '</script>';

    }

 
    }


?>