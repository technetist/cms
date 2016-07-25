<?php
	if (isset($_GET['p_id'])) {
		$the_post_id = $_GET['p_id'];
	}
	$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
    $select_posts_by_id = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = escape($row['post_id']);
        $post_author = escape($row['post_author']);
        $post_title = escape($row['post_title']);
        $post_category = escape($row['post_category_id']);
        $post_status = escape($row['post_status']);
        $post_image = escape($row['post_image']);
        $post_content = escape($row['post_content']);
        $post_tags = escape($row['post_tags']);
        $post_comments = escape($row['post_comment_count']);
        $post_date = escape($row['post_date']);
    }
    if (isset($_POST['edit_post'])) {
    	$post_author = escape($_POST['author']);
    	$post_title = escape($_POST['title']);
    	$post_category_id = escape($_POST['post_category']);
    	$post_status = escape($_POST['post_status']);
    	$post_image = escape($_FILES['image']['name']);
    	$post_image_temp = escape($_FILES['image']['tmp_name']);
    	$post_content = escape($_POST['post_content']);
    	$post_tags = escape($_POST['post_tags']);

    	move_uploaded_file($post_image_temp, "../images/$post_image");

    	if (empty($post_image)) {
    		$query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
    		$select_image = mysqli_query($connection, $query);
    		while($row = mysqli_fetch_array($select_image)) {
				$post_image = $row['post_image'];
			}
    	}

    	$query = "UPDATE posts SET ";
    	$query .= "post_title = '{$post_title}', ";
    	$query .= "post_category_id = '{$post_category_id}', ";
    	$query .= "post_date = now(), ";
    	$query .= "post_author = '{$post_author}', ";
    	$query .= "post_status = '{$post_status}', ";
    	$query .= "post_tags = '{$post_tags}', ";
    	$query .= "post_content= '{$post_content}', ";
    	$query .= "post_image = '{$post_image}' ";
    	$query .= "WHERE post_id = {$the_post_id}";

    	$update_post = mysqli_query($connection, $query);

    	confirmQuery($update_post);

        echo "<p class='bg-success' style='padding: 10px'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>Edit More Posts</a>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Post Title</label>
		<input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
	</div>
	<div class="form-group">
		<label for="post_category_id">Post Category </label>
		<select name="post_category" id="post_category_id">
			<?php

				$query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);

                confirmQuery($select_categories);

                while ($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    
                    if($post_category == $cat_id){

                        echo "<option selected value='$cat_id'>{$cat_title}</option>";

                        } else {

                        echo "<option value='$cat_id'>{$cat_title}</option>";

                        }
                }
			?>

		</select>
	</div>
	<div class="form-group">
		<label for="author">Post Author</label>
        
		<input value="<?php echo $post_author; ?>" type="text" class="form-control" name="author">
	</div>
	<div class="form-group">
		<label for="post_status">Post Status </label>
		
        <select name="post_status" id="post_status">
            <option value="Draft" <?php if($post_status=="Draft") echo 'selected="selected"'; ?> >Draft</option>
            <option value="Published" <?php if($post_status=="Published") echo 'selected="selected"'; ?> >Published</option>
        </select>
        
	</div>
	<div class="form-group">
		<label for="post_image">Post Image </label>
		<img src="../images/<?php echo $post_image; ?>" alt="Post Image" width="150">
		<input type="file" name="image">
	</div>
	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
	</div>
	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo stripslashes(str_replace('\r\n',PHP_EOL,$post_content)); ?></textarea>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="edit_post" value="Update Post">
	</div>
</form>