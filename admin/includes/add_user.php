<?php
	if (isset($_POST['create_user'])) {
		$user_firstname = escape($_POST['user_firstname']);
		$user_lastname = escape($_POST['user_lastname']);
		$user_role = escape($_POST['user_role']);
		$username= escape($_POST['username']);
		$user_email = escape($_POST['user_email']);
		$user_password = escape($_POST['user_password']);

		
		$new_user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10) );

		$query = "INSERT INTO users(user_firstname, user_lastname, username, user_role, user_email, user_password) ";
		$query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$username}', '{$user_role}', '{$user_email}', '{$new_user_password}' ) ";
		
		$create_user_query = mysqli_query($connection, $query);

		confirmQuery($create_user_query);

		echo "User Created:" . " " . "<a href='users.php'>View Users</a>";

	}
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input type="text" class="form-control" name="user_firstname" id="user_firstname">
	</div>
	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input type="text" class="form-control" name="user_lastname" id="user_lastname">
	</div>
	<div class="form-group">
		<label for="author">User Role</label>
		<select name="user_role" id="user_role">
			<option value="Subscriber">Select</option>
			<option value="Admin">Admin</option>
			<option value="Subscriber">Subscriber</option>
		</select>
	</div>
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username" id="username">
	</div>
	<div class="form-group">
		<label for="user_email">Email</label>
		<input type="email" class="form-control" name="user_email" id="user_email"></input>
	</div>

	<div class="form-group">
		<label for="user_password">Password</label>
		<input type="password" class="form-control" name="user_password" id="user_password">
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_user" value="Add User">
	</div>
</form>