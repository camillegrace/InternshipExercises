<?php 

$db = new PDO(mysql:host=localhost;dbname=netzwelt",$user,$pass);

$usersQuery = "
	SELECT 
		users.id,
		users.lastname,
		users.firtsname,
		projects.id
	FROM users
	LEFT JOIN userproject
	ON users.user_id = userproject.id
	LEFT JOIN projects
	ON userproject.id = projects.id
";

$users = $db->query($usersQuery);

?>

<!DOCTYPE html>
<html lang = "en>
<head>
</head>
<body>
	<?php foreach($users->fetchAll() as $user):?>
		<?php echo $user['lastname']; ?>
	<?php endforeach; ?>
</body>
