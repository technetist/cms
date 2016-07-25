<?php
    include "delete_modal.php";
    if (isset($_POST['checkBoxArray'])) {
        foreach ($_POST['checkBoxArray'] as $postValueID) {
            $bulk_options = escape($_POST['bulk_options']);
            switch ($bulk_options) {
                case 'Published':
                    $query = "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id={$postValueID} ";
                    $update_to_published_status = mysqli_query($connection, $query);
                    break;
                case 'Draft':
                    $query = "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id={$postValueID} ";
                    $update_to_Draft_status = mysqli_query($connection, $query);
                    break;
                    case 'Delete':
                    $query = "DELETE FROM posts WHERE post_id={$postValueID} ";
                    $bulk_delete = mysqli_query($connection, $query);
                    break;
                    case 'Clone':
                    $query = "SELECT * FROM posts WHERE post_id={$postValueID} ";
                    $bulk_clone = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_array($bulk_clone)){
                        $post_author = escape($row['post_author']);
                        $post_title = escape($row['post_title']);
                        $post_category = escape($row['post_category_id']);
                        $post_status = escape($row['post_status']);
                        $post_image = escape($row['post_image']);
                        $post_tags = escape($row['post_tags']);
                        $post_content = escape($row['post_content']);
                        $post_date = escape($row['post_date']);
                    }
                    $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_status, post_image, post_tags, post_content, post_date) ";
                    $query .= "VALUES ({$post_category}, '{$post_title}', '{$post_author}', '{$post_status}', '{$post_image}', '{$post_tags}', '{$post_content}', now())";   
                    $copy_query = mysqli_query($connection, $query);
                    if (!$copy_query) {
                         die("Query Failed" . mysqli_error($connection));
                     } 
                    break;
                    case 'Reset':
                    $query = "UPDATE posts SET post_views = 0 WHERE post_id={$postValueID} ";
                    $bulk_reset = mysqli_query($connection, $query);
                    if (!$bulk_reset) {
                        die(mysqli_error($connection));
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
?>

<form action="" method='post'>
    <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4 menuSpacing btnSpacing">
            <select name="bulk_options" id="" class="form-control">
                <option value="">Select An Option</option>
                <option value="Published">Publish</option>
                <option value="Draft">Draft</option>    
                <option value="Clone">Clone</option>
                <option value="Reset">Reset Views</option>
                <option value="Delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-4 btnSpacing">
            <input type="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Categories</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>

            <?php
            //     $query = "SELECT * FROM posts ORDER BY post_id DESC ";
                $query = "SELECT posts.post_id, posts.post_author, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
                $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views, categories.cat_id, categories.cat_title ";
                $query .= "FROM posts ";
                $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC ";
                $select_posts_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_posts_query)) {
                    $post_id = escape($row['post_id']);
                    $post_author = escape($row['post_author']);
                    $post_title = escape($row['post_title']);
                    $post_category = escape($row['post_category_id']);
                    $post_status = escape($row['post_status']);
                    $post_image = escape($row['post_image']);
                    $post_tags = escape($row['post_tags']);
                    $post_comments = escape($row['post_comment_count']);
                    $post_date = escape($row['post_date']);
                    $post_views = escape($row['post_views']);
                    $category_title = escape($row['cat_title']);
                    $category_id = escape($row['cat_id']);

                    if(empty($post_author)){
                       $post_author = 'No Author';
                    }
                    if(empty($post_title)){
                       $post_title = 'No Post Title';
                    }
                    if(empty($post_image)){
                       $post_image = 'No Image';
                    }
                    if(empty($post_tags)){
                       $post_tags = 'No Tags';
                    }
                    

                    echo "<tr>";
                    ?>
                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
                    <?php
                    echo "<td>{$post_id}</td>";

                    echo "<td>{$post_author}</td>";
                    echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</td>";
                    echo "<td>{$category_title}</td>";
                    echo "<td>{$post_status}</td>";
                    echo "<td><img src='../images/$post_image' alt='post image' width='150px'></td>";
                    echo "<td>{$post_tags}</td>";
                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $send_comment_query = mysqli_query($connection, $query);
                    $row = mysqli_fetch_array($send_comment_query);
                    $comment_id = escape($row['comment_id']);
                    $count_comments= mysqli_num_rows($send_comment_query);
                    echo "<td><a href='post_comments.php?id=$post_id'>{$count_comments}</a></td>";
                    echo "<td>{$post_date}</td>";
                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to reset post views?')\" href='posts.php?reset={$post_id}'>{$post_views}</a></td>";
                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                    // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this?')\" href='posts.php?delete={$post_id}'>Delete</a></td>";
                    echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
                    echo "</tr>";
                }
            ?>

          
      </tbody> 
    </table>
<?php
    if (isset($_GET['delete'])) {
        $the_post_id = escape($_GET['delete']);

        $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: posts.php");
    }
    if (isset($_GET['reset'])) {

        $query = "UPDATE posts SET post_views = 0 WHERE post_id = " . mysqli_real_escape_string($connection, $_GET['reset']) . " ";
        $reset_query = mysqli_query($connection, $query);
        header("Location: posts.php");
    }
?> 

<script>
    $(document).ready(function(){
        $(".delete_link").on('click', function(){
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id +"";
            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');
        });
    });
</script>