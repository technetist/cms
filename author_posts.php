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
                    All Posts By <?php echo escape($_GET['author']) ?>
                    <small>Secondary Text</small>
                </h1>
                
                <?php
                    if (isset($_GET['p_id'])) {
                        $the_post_id = escape($_GET['p_id']);
                        $the_post_author = escape($_GET['author']);
                    }
                    $query = "SELECT * FROM posts WHERE post_author = '{$the_post_author}'";
                    $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_title = escape($row['post_title']);
                        $post_author = escape($row['post_author']);
                        $post_date = escape($row['post_date']);
                        $post_image = escape($row['post_image']);
                        $post_content = mysqli_real_escape_string($connection, html_cut($row['post_content'], 200));

                ?>
                    

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <?php echo $post_author ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo stripslashes(str_replace('\r\n',PHP_EOL,$post_content)) ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php } ?>

                <?php
                    if ($_SESSION['role']=='Admin') {
                        if (isset($_GET['p_id'])) {
                            $the_post_id = escape($_GET['p_id']);
                            echo "<a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'' class='btn btn-default pull-right' role='button'><span class='fa fa-edit'></span> Edit Post</a> <div class='clearfix'></div>";
                            echo "<hr>";
                        }
                    }
                ?>
             </div>

            <!-- Blog Sidebar Widgets Column -->
                    
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php" ?>
