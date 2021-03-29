<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Manage Departments</title>
</head>

<body>
    <h1>Manage Departments</h1>
    <p><a href="?add">Add new department</a></p>
    <table border="1px">
        <?php foreach($departments as $Department): ?>
        <form action="" method="post">
            <tr>
                <td><?php html($Department['Name']); ?> </td>
                <input type="hidden" name="ID" value="<?php echo $Department['ID']; ?>">
                <td><input type="submit" name="action" value="Edit"></td>
                <td><input type="submit" name="action" value="Delete"></td>
            </tr>
        </form>
        <?php endforeach; ?>
    </table>
    <?php include_once '../logout.inc.html.php';?>
    <p><a href="..">Return to CMS home</a></p>
</body>

</html>