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
                    <small>Secondary Text</small>
                </h1>
                
                <?php
                    
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
                       $post_query_count = "SELECT * FROM posts";
                    }else {
                        $post_query_count = "SELECT * FROM posts WHERE post_status='Published'";
                    }
                    
                    $find_count = mysqli_query($connection, $post_query_count);
                    $count = mysqli_num_rows($find_count);
                    

                    if($count < 1 ){
                        echo "<h1 class='text-center'>No Posts Available</h1>";
                    } else{
                            if (isset($_SESSION['per_page'])) {
                            $per_page = escape($_SESSION['per_page']);
                            } else{
                                $per_page = 5;
                            }
                            if (isset($_POST['per_page'])) {
                                $per_page = escape($_POST['per_page']);
                                $_SESSION['per_page']=$per_page;
                            }

                            if (isset($_GET['page'])) {
                                $page=escape($_GET['page']);
                            } else{
                                $page=1;
                            }

                            if ($page==1 || $page==1) {
                                $page_1 = 0;
                            } else{
                                $page_1 = ($page * $per_page) - $per_page;
                            }
                                $count = ceil($count / $per_page);
                            if($page > $count) {
                                header("Location: index.php");
                            }

                    
                    
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
                       $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
                    }else {
                        $query = "SELECT * FROM posts WHERE post_status = 'Published' LIMIT $page_1, $per_page ";
                    }
                    
                    $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = escape($row['post_id']);
                        $post_title = escape($row['post_title']);
                        $post_author = escape($row['post_author']);
                        $post_date = escape($row['post_date']);
                        $post_image = escape($row['post_image']);
                        $post_content = mysqli_real_escape_string($connection, html_cut($row['post_content'], 200));
                        $post_status = escape($row['post_status']);

                        $rowsReturned=mysqli_num_rows($select_all_posts_query);
                        


                ?>
                    

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
               <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="Post Image"></a>
                <hr>
                <p><?php echo stripslashes(str_replace('\r\n',PHP_EOL,$post_content)) ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php } } ?>

                

            </div>

            <!-- Blog Sidebar Widgets Column -->
                    
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->
        <ul class="pager">
            <?php
            if($count >= 1 ){
                for ($i=1; $i <= $count; $i++) { 
                    if($i == $page){
                        echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                    } else {
                        echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                    }
                }
            }
            ?>
        </ul>
        <?php if($count >= 1 ){ ?>
        <form action="" method="post" class="per_page">
            <p>How many posts per page?<p>
            <select name="per_page">
                <option value="1" <?php if($per_page == 1){echo 'selected';} ?> >1</option>
                <option value="2" <?php if($per_page == 2){echo 'selected';} ?> >2</option>
                <option value="5" <?php if($per_page == 5){echo 'selected';} ?> >5</option>
                <option value="10" <?php if($per_page == 10){echo 'selected';} ?> >10</option>
                <option value="15" <?php if($per_page == 15){echo 'selected';} ?> >15</option>
                <option value="20" <?php if($per_page == 20){echo 'selected';} ?> >20</option>
            </select>
            <input type="submit" value="Go">
        <form>
        <?php } ?>
        <hr>

<?php include "includes/footer.php" ?>
