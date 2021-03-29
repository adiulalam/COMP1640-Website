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

include '../includes/db.inc.php';

// idea Statistics
    try
    {

    $result= $pdo->query('select count(*) from Idea');

    foreach ($result as $row)
{
    echo ("Total number of Ideas: ".$row["count(*)"]);
}


    }
catch (PDOException $e)
{
    $error = 'Error getting Idea statistics';
    include 'error.html.php';
    exit();
}

// Author Statistics
    try
    {

    $result= $pdo->query('select count(*) from Author');

    foreach ($result as $row)
{
    echo ("<br> Total number of Authors: ".$row["count(*)"]);
}


    }
catch (PDOException $e)
{
    $error = 'Error getting authors statistics';
    include 'error.html.php';
    exit();
}

// category Statistics
    try
    {

    $result= $pdo->query('select count(*) from Category');

    foreach ($result as $row)
{
    echo ("<br> Total number of Categories: ".$row["count(*)"]);
}


    }
catch (PDOException $e)
{
    $error = 'Error getting category statistics';
    include 'error.html.php';
    exit();
}

// department Statistics
    try
    {

    $result= $pdo->query('select count(*) from Department');

    foreach ($result as $row)
{
    echo ("<br> Total number of Departments: ".$row["count(*)"]);
}


    }
catch (PDOException $e)
{
    $error = 'Error getting Departments statistics';
    include 'error.html.php';
    exit();
}

// comment Statistics
    try
    {

    $result= $pdo->query('select count(*) from Comment');

    foreach ($result as $row)
{
    echo ("<br> Total number of Comments: ".$row["count(*)"]);
}


    }
catch (PDOException $e)
{
    $error = 'Error getting Comments statistics';
    include 'error.html.php';
    exit();
}

?>


<!DOCTYPE html>
<html lang= "en">
<head>
    <meta charset="UTF-8">
    <title>Statistics and Export</title>
</head>
<body>

<form method ="post" action="authorexport.php">
    <br><input type="submit" name="export" value="Author CSV Export" /> 
</form>

<form method ="post" action="authorroleexport.php">
    <br><input type="submit" name="export" value="Author Role CSV Export" /> 
</form>

<form method ="post" action="categoryexport.php">
    <br><input type="submit" name="export" value="Category CSV Export" /> 
</form>

<form method ="post" action="departmentexport.php">
    <br><input type="submit" name="export" value="Department CSV Export" /> 
</form>

<form method ="post" action="ideaexport.php">
    <br><input type="submit" name="export" value="Idea CSV Export" /> 
</form>

<form method ="post" action="ideacategoryexport.php">
    <br><input type="submit" name="export" value="Idea Category CSV Export" /> 
</form>

<form method ="post" action="roleexport.php">
    <br><input type="submit" name="export" value="Role CSV Export" /> 
</form>

<form method ="post" action="commentexport.php">
    <br><input type="submit" name="export" value="Comment CSV Export" /> 
</form>


</body>
</html>

