<?php include "db.php"; ?>
<?php include "../main_functions.php"; ?>
<?php session_start(); ?>

<?php 
if (isset($_POST['login'])) {
	$username=$_POST['username'];
	$password=$_POST['password'];

	$sanitized_username = mysqli_real_escape_string($connection, $username);
	$sanitized_password = mysqli_real_escape_string($connection, $password);

	$query = "SELECT * FROM users WHERE username = '{$sanitized_username}'";
	$select_user_query = mysqli_query($connection, $query);
	if (!$select_user_query) {
		die("QUERY Failed". mysqli_error($connection));
	}
	while ($row = mysqli_fetch_array($select_user_query)) {
		$db_user_id = escape($row['user_id']);
		$db_user_firstname = escape($row['user_firstname']);
		$db_user_lastname = escape($row['user_lastname']);
		$db_user_role = escape($row['user_role']);
		$db_username = escape($row['username']);
		$db_user_password = escape($row['user_password']);
	}
	if (password_verify($sanitized_password, $db_user_password)) {
		$_SESSION['user_id'] = $db_user_id;
		$_SESSION['username'] = $db_username;
		$_SESSION['firstname'] = $db_user_firstname;
		$_SESSION['lastname'] = $db_user_lastname;
		$_SESSION['role'] = $db_user_role;
	}
	else {
		header("Location: ../index.php");
	}

	if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
		header("Location: ../admin");
	}
	else {
		header("Location: ../index.php");
	}
}
?>