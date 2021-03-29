<?php
require_once '../includes/access.inc.php';

if (!userIsLoggedIn()){ 
    include '../login.html.php'; 
    exit();
} 

if (userHasRole('Content Editor') or userHasRole('Account Administrator') or userHasRole('Site Administrator'))
{

}
else
{
    $error='Only Content Editor or Account Administrators or Site Administrator may access this page.';
    include '../accessdenied.html.php'; 
    exit(); 
}

/*****************************************************/
//Add new Idea

if(isset($_GET['add']))
{
    $pageTitle = 'New Idea';
    $action = 'addform';
    $text='';
    $AuthorID='';
    $ID='';
    $button='Add Idea';
    
    include '../includes/db.inc.php';
    
    try
    {
        $result= $pdo->query('SELECT Author_ID, Name FROM Author');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of authors';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row){
    $authors[]= array('ID' => $row['Author_ID'], 'Name'=>$row['Name'] );
}

//build list of departments    
     try
    {
        $result= $pdo->query('SELECT ID, Name FROM Department');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of department';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $departments[]=array('ID' => $row['ID'], 'Name'=>$row['Name'], 'selected' => FALSE );
}
    
//build list of categories    
     try
    {
        $result= $pdo->query('SELECT ID, Name FROM Category');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of categories';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $categories[]=array('ID' => $row['ID'], 'Name'=>$row['Name'], 'selected' => FALSE );
}

include 'form.html.php';
exit();
}

/*****************************************************/
//Insert idea

if(isset($_GET['addform']))
{
    include '../includes/db.inc.php';
    
    if($_POST['Author']=='')
    {
        $error='You must choose an author for this idea, Click back and try again';
        include 'error.html.php';
        exit();
    }
    
    try
    {
        $sql = 'INSERT INTO Idea SET
        IdeaText=:IdeaText,
        IdeaDate=CURDATE(),
        AuthorID=:AuthorID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':IdeaText', $_POST['text']);
        $s->bindvalue(':AuthorID', $_POST['Author']);
        $s->execute();
    }
    
        catch (PDOException $e)
{
    $error = 'Error adding submitted idea';
    include 'error.html.php';
    exit();
}

$IdeaID = $pdo->lastInsertId();


/*****************************************************/
//Insert record into authorcategory table

if(isset($_POST['categories']))
{
    try
    {
        $sql = 'INSERT INTO IdeaCategory SET
        IdeaID=:IdeaID,
        CategoryID=:CategoryID';
        $s =$pdo->prepare($sql);
        foreach ($_POST['categories'] as $CategoryID)
        {
            $s->bindvalue(':IdeaID', $IdeaID);
            $s->bindvalue(':CategoryID', $CategoryID);
            $s->execute();
        }
    }
catch (PDOException $e)
{
    $error = 'Error inserting idea into selected categories';
    include 'error.html.php';
    exit();
}
}

/*****************************************************/
//Insert record into ideadepartment table --department

if(isset($_POST['departments']))
{
    try
    {
        $sql = 'INSERT INTO IdeaDepartment SET
        IdeaID=:IdeaID,
        DepartmentID=:DepartmentID';
        $s =$pdo->prepare($sql);

        foreach ($_POST['departments'] as $DepartmentID)
        {
            $s->bindvalue(':IdeaID', $IdeaID);
            $s->bindvalue(':DepartmentID', $DepartmentID);
            $s->execute();
        }
    }
catch (PDOException $e)
{
    $error = 'Error inserting idea into selected departments';
    include 'error.html.php';
    exit();
}
}

header('Location: .');
exit();
}



/*****************************************************/
//edit idea button been clicked

if(isset($_POST['action']) and $_POST['action']=='Edit')
{
    include '../includes/db.inc.php';
try
{
    $sql = 'SELECT ID, IdeaText, AuthorID FROM Idea WHERE ID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching idea details';
    include 'error.html.php';
    exit();
}
    
$row = $s->fetch();
    $pageTitle='Edit Idea';
    $action='editform';
    $text=$row['IdeaText'];
    $AuthorID=$row['AuthorID'];
    $ID=$row['ID'];
    $button='Update Idea';
    
    //build list of authors
    try
    {
        $result= $pdo->query('SELECT Author_ID, Name FROM Author');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of authors';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $authors[]=array('ID' => $row['Author_ID'], 'Name'=>$row['Name'] );
}
    

 /*****************************************************/
//build list of categories     
try
{
    $sql = 'SELECT CategoryID FROM IdeaCategory WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $ID);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching lists of selected categories';
    include 'error.html.php';
    exit();
}
    
foreach ($s as $row)
{
    $selectedCategories[]=$row['CategoryID'];
}


//build list of categories  
    try
    {
        $result= $pdo->query('SELECT ID, Name FROM Category');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of categories';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $categories[]=array('ID' => $row['ID'], 'Name'=>$row['Name'], 'selected' => in_array($row['ID'], $selectedCategories));
}


/*****************************************************/   
//get list of departments containing this idea
    
try
{
    $sql = 'SELECT DepartmentID FROM IdeaDepartment WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $ID);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching lists of selected Departments';
    include 'error.html.php';
    exit();
}
    
foreach ($s as $row)
{
    $selectedDepartments[]=$row['DepartmentID'];
}


//build list of Departments  

    try
    {
        $result= $pdo->query('SELECT ID, Name FROM Department');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of Departments';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $departments[]=array('ID' => $row['ID'], 'Name'=>$row['Name'], 'selected' => in_array($row['ID'], $selectedDepartments));
}

//show the edit idea version of the form
include 'form.html.php';
exit();
}
    
/*****************************************************/
//update the edited idea

if(isset($_GET['editform']))
{
    include '../includes/db.inc.php';
    
    if($_POST['Author'] == '')
    {
        $error='You must choose an author for this idea, Click back and try again';
        include 'error.html.php';
        exit();
    }
    
    try
    {
        $sql = 'UPDATE Idea SET
        IdeaText=:IdeaText,
        AuthorID=:AuthorID
        WHERE ID=:ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':IdeaText', $_POST['text']);
        $s->bindvalue(':AuthorID', $_POST['Author']);
        $s->execute();
    }
    
    catch (PDOException $e)
{
    $error = 'Error updating submitted idea';
    include 'error.html.php';
    exit();
}
//****// Category
 try
    {
        $sql = 'DELETE FROM IdeaCategory WHERE IdeaID=:ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->execute();
    }
    
    catch (PDOException $e)
{
    $error = 'Error removing obsolete idea category entries';
    include 'error.html.php';
    exit();
}
if(isset($_POST['categories']))
{    
try
    {
        $sql = 'INSERT INTO IdeaCategory SET 
        IdeaID= :IdeaID, 
        CategoryID=:CategoryID';
        $s =$pdo->prepare($sql);
        foreach ($_POST['categories'] as $CategoryID)
        {
            $s->bindvalue(':IdeaID', $_POST['ID']);
            $s->bindvalue(':CategoryID', $CategoryID);
            $s->execute();
        }
    }
    
    catch (PDOException $e)
{
    $error = 'Error inserting idea into selected categories';
    include 'error.html.php';
    exit();
}
}

//****/// Department
 try
    {
        $sql = 'DELETE FROM IdeaDepartment WHERE IdeaID=:ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->execute();
    }
    
    catch (PDOException $e)
{
    $error = 'Error removing obsolete idea Department entries';
    include 'error.html.php';
    exit();
}

if(isset($_POST['departments']))
{    
try
    {
        $sql = 'INSERT INTO IdeaDepartment SET 
        IdeaID= :IdeaID, 
        DepartmentID=:DepartmentID';
        $s =$pdo->prepare($sql);
        foreach ($_POST['departments'] as $DepartmentID)
        {
            $s->bindvalue(':IdeaID', $_POST['ID']);
            $s->bindvalue(':DepartmentID', $DepartmentID);
            $s->execute();
        }
    }
    
    catch (PDOException $e)
{
    $error = 'Error inserting idea into selected Department';
    include 'error.html.php';
    exit();
}
}

    
header('Location: .');
exit();
}


/*****************************************************/
//delete the idea

if(isset($_POST['action']) and $_POST['action']=='Delete')
{
    include '../includes/db.inc.php';
try
{
    $sql = 'SELECT IdeaID FROM IdeaCategory WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting idea from categories';
    include 'error.html.php';
    exit();
}
    
//delete the idea
try
{
    $sql = 'SELECT ID, IdeaText FROM Idea WHERE ID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching idea';
    include 'error.html.php';
    exit();
}
    $row = $s->fetch();
    $IdeaText=$row['IdeaText'];
    $ID=$row['ID'];
    
include 'confirm_delete.html.php';
exit();
}
//delete the idea

if(isset($_POST['action']) and $_POST['action']=='Yes')
{
    include '../includes/db.inc.php';

 //delete the idea category
try
{
    $sql = 'DELETE FROM IdeaCategory WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error removing idea from categories';
    include 'error.html.php';
    exit();
}

//delete the idea department
try
{
    $sql = 'DELETE FROM IdeaDepartment WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error removing idea from categories';
    include 'error.html.php';
    exit();
}
    
//delete the idea
try
{
    $sql = 'DELETE FROM Idea WHERE ID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting idea';
    include 'error.html.php';
    exit();
}

//delete the Comment
try
{
    $sql = 'DELETE FROM Comment WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting idea';
    include 'error.html.php';
    exit();
}


header('Location: .');
exit();
}


/*****************************************************/


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

include 'searchform.html.php';

//********************

?>