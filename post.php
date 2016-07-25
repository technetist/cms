<?php session_start();?>
<?php include "includes/db.php" ?>

<?php include "includes/header.php" ?>


    <!-- Navigation -->
    <?php include "includes/nav.php" ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    Post
                    <small>Secondary Text</small>
                </h1>
                
                <?php
                    if (isset($_GET['p_id'])) {
                        $the_post_id = escape($_GET['p_id']);

                        $view_query = "UPDATE posts SET post_views = post_views + 1 WHERE post_id = $the_post_id";
                        $send_query = mysqli_query($connection, $view_query);
                        if (!$send_query) {
                            die("Query Failed " . mysqli_error($connection));
                        }

                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
                           $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                        }else {
                            $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'Published' ";
                        }
                    
                    $select_all_posts_query = mysqli_query($connection, $query);

                    if(mysqli_num_rows($select_all_posts_query) < 1) {
                        echo "<h1 class='text-center'>No Posts Available</h1>";
                    } else {

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_title = escape($row['post_title']);
                        $post_author = escape($row['post_author']);
                        $post_date = escape($row['post_date']);
                        $post_image = escape($row['post_image']);
                        $post_content = escape($row['post_content']);

                ?>
                    

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo stripslashes(str_replace('\r\n',PHP_EOL,$post_content)) ?></p>

                <hr>

                <?php } 
                ?>

                <?php
                    if ($_SESSION['role']=='Admin') {
                        if (isset($_GET['p_id'])) {
                            $the_post_id = escape($_GET['p_id']);
                            echo "<a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'' class='btn btn-default pull-right' role='button'><span class='fa fa-edit'></span> Edit Post</a> <div class='clearfix'></div>";
                            echo "<hr>";
                        }
                    }
                ?>
            
                <!-- Blog Comments -->

                <?php
                    if (isset($_POST['create_comment'])) {
                        
                        $the_post_id = escape($_GET['p_id']);
                        $comment_author = escape($_POST['comment_author']);
                        $comment_email = escape($_POST['comment_email']);
                        $comment_content = escape($_POST['comment_content']);

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                            $query .= "VALUES ($the_post_id , '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Visible', now())";
                            
                            $create_comment_query = mysqli_query($connection, $query);
                            if(!$create_comment_query){
                                die('QUERY FAILED' . mysqli_error($connection));
                            }
                            // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                            // $query .= "WHERE post_id = $the_post_id ";
                            // $update_comment_count = mysqli_query($connection, $query);
                        } else {
                            echo "<script>alert('Fields cannot be empty')</script>";
                        }

                       

                        
                    }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">E-Mail</label>
                            <input type="email" name="comment_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Comment</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                
                <hr>

                <!-- Posted Comments -->
                <?php
                    $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
                    $query .= "AND comment_status = 'Visible' ";
                    $query .= "ORDER BY comment_id DESC ";
                    $select_comment_query = mysqli_query($connection, $query);
                    if (!$select_comment_query) {
                        die("QUERY FAILED" . mysqli_error($connection));
                    }
                    while ($row = mysqli_fetch_array($select_comment_query)) {
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];

                ?>

                

                    <!-- Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $comment_author; ?>
                                <small><?php echo $comment_date; ?></small>
                            </h4>
                            <?php echo $comment_content; ?>
                        </div>
                    </div>
                <?php } 
                } 
            }
            else{
                header("Location: index.php");
            } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
                    
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php" ?>
