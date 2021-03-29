<?php
require_once '../includes/access.inc.php';

if (!userIsLoggedIn()){ 
    include '../login.html.php'; 
    exit();
} 

if (userHasRole('Site Administrator'))
{

}
else
{
    $error='Only Site Administrators may access this page.'; 
    include '../accessdenied.html.php'; 
    exit(); 
}

if(isset($_GET['add']))
{
    $pageTitle = 'New Department';
    $action = 'addform';
    $Name='';
    $ID='';
    $button='Add Department';
    
    include 'form.html.php';
    exit();
}

if(isset($_GET['addform']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'INSERT INTO Department SET Name=:Name';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':Name', $_POST['Name']);
        $s->execute();
    }
catch (PDOException $e)
{
    $error = 'Error adding submitted Department';
    include 'error.html.php';
    exit();
}
header('Location: .');
exit();
}

if(isset($_POST['action']) and $_POST['action']=='Edit')
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'SELECT ID, Name FROM Department WHERE ID= :ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->execute();
    }
catch (PDOException $e)
{
    $error = 'Error fetching Department details';
    include 'error.html.php';
    exit();
}
    
$row = $s->fetch();
    $pageTitle='Edit Department';
    $action='editform';
    $Name=$row['Name'];
    $ID=$row['ID'];
    $button='Update department';
include 'form.html.php';
exit();
}
  
if(isset($_GET['editform']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'UPDATE Department SET
        Name=:Name
        WHERE ID=:ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':Name', $_POST['Name']);
        $s->execute();
    }
catch (PDOException $e)
{
    $error = 'Error adding submitted Department';
    include 'error.html.php';
    exit();
}
header('Location: .');
exit();
}

///////
if(isset($_POST['action']) and $_POST['action']=='Delete'){
include '../includes/db.inc.php';
   
// try{
//     $sql= 'SELECT CategoryID FROM IdeaCategory WHERE CategoryID = :ID';
//     $s =$pdo->prepare($sql);
//     $s->bindvalue(':ID', $_POST['ID']);
//     $s->execute();
// }
// catch (PDOException $e)
// {
//     $error = 'Error removing ideas from category';
//     include 'error.html.php';
//     exit();
// }


try{
    $sql= 'SELECT ID FROM Department WHERE ID = :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting Department';
    include 'error.html.php';
    exit();
}
    $row = $s->fetch();
    $ID=$row['ID'];
    
include 'confirm_delete.html.php';
exit();
}
///////
if(isset($_POST['action']) and $_POST['action']=='Yes')
{
    include '../includes/db.inc.php';
// try{
//     $sql= 'DELETE FROM IdeaCategory WHERE CategoryID = :ID';
//     $s =$pdo->prepare($sql);
//     $s->bindvalue(':ID', $_POST['ID']);
//     $s->execute();
// }
// catch (PDOException $e)
// {
//     $error = 'Error removing category from ideacategory';
//     include 'error.html.php';
//     exit();
// }


try{
    $sql= 'DELETE FROM Department WHERE ID = :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting Department';
    include 'error.html.php';
    exit();
}
    
header('Location: .');
exit();
}

/////

include '../includes/db.inc.php';

try{
    $result= $pdo->query('SELECT ID, Name From Department');
}
catch (PDOException $e)
{
    $error = 'Error fetching Department from the database';
    include 'error.html.php';
    exit();
}


foreach ($result as $row)
   {
       $departments[]=array('ID' => $row['ID'], 'Name' => $row['Name']);
   }
    
include 'departments.html.php';
   
?>