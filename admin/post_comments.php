<?php include "includes/adminHeader.php" ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/adminNav.php" ?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to your Admin Panel
                            <small>Author</small>
                        </h1>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In Response To</th>
                <th>Date</th>
                <th>Visible</th>
                <th>Invisible</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>

            <?php
                $query = "SELECT * FROM comments WHERE comment_post_id = " . mysqli_real_escape_string($connection, $_GET['id']);
                $select_comments_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_comments_query)) {
                    $comment_id = escape($row['comment_id']);
                    $comment_post_id = escape($row['comment_post_id']);
                    $comment_author = escape($row['comment_author']);
                    $comment_content = escape($row['comment_content']);
                    $comment_email = escape($row['comment_email']);
                    $comment_date = escape($row['comment_date']);
                    $comment_status = escape($row['comment_status']);

                    echo "<tr>";
                    echo "<td>{$comment_id}</td>";
                    echo "<td>{$comment_author}</td>";
                    echo "<td>{$comment_content}</td>";

                   

                    echo "<td>{$comment_email}</td>";
                    echo "<td>{$comment_status}</td>";

                    $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
                    $select_post_id_query = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($select_post_id_query)){
                        $post_id = escape($row['post_id']);
                        $post_title = escape($row['post_title']);
                        echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                    }         
                    echo "<td>{$comment_date}</td>";

                    echo "<td><a href='post_comments.php?visible=$comment_id&id=".escape($_GET['id'])."'>Visible</a></td>";
                    echo "<td><a href='post_comments.php?invisible=$comment_id&id=".escape($_GET['id'])."'>Invisible</a></td>";

                    echo "<td><a href='post_comments.php?delete=$comment_id&id= ".escape($_GET['id'])."'>Delete</a></td>";
                    echo "</tr>";
                }
            ?>

          
      </tbody> 
    </table>
<?php
    deleteComment();
    
    visibleComment();
    
    invisibleComment();
?> 
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/adminFooter.php" ?>