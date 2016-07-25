<?php session_start(); ?>
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
                    Page Heading
                    <small>Sample Text</small>
                </h1>
                
                <?php
                    if (isset($_GET['category'])) {
                        $post_category_id = escape($_GET['category']);
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
                           $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id";
                        }else {
                            $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'Published' ";
                        }
                    $select_all_posts_query = mysqli_query($connection, $query);
                    if(mysqli_num_rows($select_all_posts_query) < 1) {
                        echo "<h1 class='text-center'>No Posts Available</h1>";
                    } else {
                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = escape($row['post_id']);
                        $post_title = escape($row['post_title']);
                        $post_author = escape($row['post_author']);
                        $post_date = escape($row['post_date']);
                        $post_image = escape($row['post_image']);
                        $post_content = mysqli_real_escape_string($connection, html_cut($row['post_content'], 200));

                ?>
                    

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
               <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="Post Image"></a>
                <hr>
                <p><?php echo stripslashes(str_replace('\r\n',PHP_EOL,$post_content)) ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php } } } else{
                    header("Location: index.php");
                }?>

                

            </div>

            <!-- Blog Sidebar Widgets Column -->
                    
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php" ?>
