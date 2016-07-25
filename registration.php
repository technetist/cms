<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php 

    if (isset($_POST['submit'])) {
        $username = escape($_POST['username']);
        $email = escape($_POST['email']);
        $password = escape($_POST['password']);

        if (!empty($username) && !empty($email) && !empty($password)) {
            $sanitized_username = mysqli_real_escape_string($connection, $username);
            $sanitized_email = mysqli_real_escape_string($connection, $email);
            $sanitized_password = mysqli_real_escape_string($connection, $password);

            $password = password_hash($sanitized_password, PASSWORD_BCRYPT, array('cost' => 12) );

                //old password method DELETE!!
            // $query = "SELECT randSalt FROM users";
            // $select_randsalt_query = mysqli_query($connection, $query);
            $message = "<h6 class='text-center bg-success'>Your registration has been submitted</h6>";
            // if (!$select_randsalt_query) {
            //     die("Query Failed" . mysqli_error($connection));
            // }
            // $row = mysqli_fetch_array($select_randsalt_query);
            // $salt = $row['randSalt'];

            // $password = crypt($password, $salt);

            $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
            $query .= "VALUES('{$username}','{$email}', '{$password}', 'Subscriber' )";
            $register_user_query = mysqli_query($connection, $query);
            if (!$register_user_query) {
                die("Query Failed " . mysqli_error($connection) . ' ' . mysqli_errorno($connection));
            }
        } 
        else{
                $message = "<h6 class='text-center bg-warning'>Fields must not be left empty</h6>";
        }

        

    } 
    else{
            $message = "";
    }

?>


<!-- Navigation -->

<?php  include "includes/nav.php"; ?>

 
<!-- Page Content -->
<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <?php echo $message; ?>
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>         
                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


<hr>



<?php include "includes/footer.php";?>
