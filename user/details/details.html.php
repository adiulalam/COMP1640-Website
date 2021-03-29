<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang= "en">
	<head>
		<meta charset="utf-8">
		<title>All Ideas Details</title>
		</head>
	<body>
        <h1>All Ideas Details</h1>
        <?php if (isset($ideas)): ?>
        <table border="1px">
            <tr><th>Idea Text</th><th>Idea Date</th><th>Author</th><th>Ingredients</th><th>Preparation Method</th><th>Preparation Time (Minutes)</th><th>Cooking Time (Minutes)</th><th>Serving (Per Person)</th><th>Reference (URL)</th></tr>
            <?php foreach ($ideas as $Idea): ?>
            <tr>
                <td><center><?php echo($Idea['text']);?></center></td>
                <td><center><?php html($Idea['IdeaDate']);?></center></td>
                <td><center><?php html($Idea['Name']);?></center></td>
            <td><textarea cols="60"  rows="10"> <?php html($Idea['Ingredients']);?></textarea></td>
            <td><textarea cols="60"  rows="10"> <?php html($Idea['PrepMethod']);?></textarea></td>
                <td><center><?php html($Idea['PrepTime']);?></center></td>
                <td><center><?php html($Idea['CookTime']);?></center></td>
                <td><center><?php html($Idea['Serving']);?></center></td>
                <td><center><?php html($Idea['Ref']);?></center></td>
            </tr>
            <?php endforeach;?>
                
        </table>
        <?php endif; ?>
        <p><a href="?">New Search</a></p>
        <p><a href="..">Return to CMS home</a></p>
	</body>
	</html>