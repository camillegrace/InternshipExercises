<?php 

$db = new PDO("mysql:host=localhost; dbname=netzwelt",'root','');

$usersQuery = "
	SELECT 
		users.user_id,
		users.lastname,
		users.firtsname
	FROM users
	LEFT JOIN userproject
	ON users.user_id = userproject.id
";

$users = $db->query($usersQuery);

?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php foreach($users->fetchAll() as $user):?>
		<?php echo $user['lastname']; ?>
	<?php endforeach; ?>
</body>
</html>
