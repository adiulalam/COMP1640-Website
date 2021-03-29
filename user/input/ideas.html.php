<?php include_once '../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List of Ideas</title>
</head>
<body>
    <!--<p><a href="?addidea">Add your own idea</a></p>-->
    <p>Here are all the ideas in the databas</p>
    <table border="1">
    <?php foreach ($ideas as $Idea): ?>
        <form action="?deleteidea" method="post">
        <tr>
        <td><?php html($Idea['IdeaText']);?></td>
        <td><?php $display_date = date("D d M Y", strtotime($Idea['IdeaDate']));
        html($display_date); ?>
        </td>
        <td><input type="hidden" name="ID" value="<?php echo $Idea['ID']; ?>">
        <input type="submit" value="Delete"></td>
        <td>(by <a href="mailto:<?php html($Idea['Email']); ?>">
            <?php html($Idea['Name']); ?></a>)</td>
        </tr>
        </form>
    <?php endforeach; ?>
    </table>
    <?php include '../includes/footer.inc.html.php'; ?>
</body>
</html>