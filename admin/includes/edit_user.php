<?php
    if (isset($_GET['edit_user'])) {
        $the_user_id = escape($_GET['edit_user']);

        $query = "SELECT * FROM users WHERE user_id = $the_user_id";
        $select_users_query = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_users_query)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_role = $row['user_role'];
            $user_image = $row['user_image'];
        }
    
    if (isset($_POST['edit_user'])) {
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username= $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        if (!empty($user_password)) {
            $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
            $get_user_query = mysqli_query($connection, $query_password);
            confirmQuery($get_user_query);

            $row = mysqli_fetch_array($get_user_query);
            $db_user_password = $row['user_password'];

            if ($db_user_password != $user_password) {
                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12) );
            }else{$hashed_password=$user_password;}

            $query = "UPDATE users SET ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_role = '{$user_role}', ";
            $query .= "username = '{$username}', ";
            $query .= "user_password = '{$hashed_password}', ";
            $query .= "user_email = '{$user_email}' ";
            $query .= "WHERE user_id = {$the_user_id}";

            $update_user_query = mysqli_query($connection, $query);

            confirmQuery($update_user_query);

            echo "User Updated" . " <a href='users.php'>View Users</a>";
        } else {
            $query = "UPDATE users SET ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_role = '{$user_role}', ";
            $query .= "username = '{$username}', ";
            $query .= "user_email = '{$user_email}' ";
            $query .= "WHERE user_id = {$the_user_id}";

            $update_user_query = mysqli_query($connection, $query);

            confirmQuery($update_user_query);

            echo "User Updated" . " <a href='users.php'>View Users</a>";

        }
    }
} else {
    header("Location: index.php");
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" value="<?php echo $user_firstname ?>" class="form-control" name="user_firstname" id="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" value="<?php echo $user_lastname ?>" class="form-control" name="user_lastname" id="user_lastname">
    </div>
    <div class="form-group">
        <label for="author">User Role</label>
        <select name="user_role" id="user_role">
            <?php 
                if ($user_role == 'Admin') {
                    echo "<option value='Admin' selected>Admin</option>
                    <option value='Subscriber'>Subscriber</option>";
                }
                else{
                    echo "<option value='Admin'>Admin</option>
                    <option value='Subscriber' selected>Subscriber</option>";  
                }
            ?>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div> -->
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" value="<?php echo $username ?>" class="form-control" name="username" id="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" value="<?php echo $user_email ?>" class="form-control" name="user_email" id="user_email"></input>
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" value="<?php $user_password ?>" class="form-control" name="user_password" id="user_password">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>
</form>