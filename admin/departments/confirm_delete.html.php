<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang= "en">
	<head>
		<meta charset="utf-8">
		<title>Confirm delete Department</title>
		</head>
	<body>
        <h1>Confirm Delete?</h1>
        <form action="" method="post">
            <div>
                Do you really want to delete this Department:
                <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                <input type="submit" name="action" value="Yes">
                <input type="submit" name="action" value="No">
            </div>
        </form>
	</body>
	</html>