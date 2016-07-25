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
                $query = "SELECT * FROM comments";
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

                    echo "<td><a href='comments.php?visible=$comment_id'>Visible</a></td>";
                    echo "<td><a href='comments.php?invisible=$comment_id'>Invisible</a></td>";

                    echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
                    echo "</tr>";
                }
            ?>

          
      </tbody> 
    </table>
<?php
    if (isset($_GET['delete'])) {
        $the_comment_id = escape($_GET['delete']);

        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }
    if (isset($_GET['invisible'])) {
        $the_comment_id = escape($_GET['invisible']);

        $query = "UPDATE comments SET comment_status = 'Invisible' WHERE comment_id = {$the_comment_id} ";
        $approve_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }
    if (isset($_GET['visible'])) {
        $the_comment_id = escape($_GET['visible']);

        $query = "UPDATE comments SET comment_status = 'Visible' WHERE comment_id = {$the_comment_id} ";
        $disapprove_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }
?> 