<?php
	if (isset($_POST['create_post'])) {
		$post_title = escape($_POST['title']);
		$post_author = escape($_POST['author']);
		$post_tags = escape($_POST['post_tags']);
		$post_category_id = escape($_POST['post_category']);
		$post_status= escape($_POST['post_status']);
		$post_image = escape($_FILES['image']['name']);
		$post_image_temp = escape($_FILES['image']['tmp_name']);
		$post_content = escape($_POST['post_content']);
		$post_date = escape(date('d-m-y'));

		move_uploaded_file($post_image_temp, "../images/$post_image");

		$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";

		$query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}','{$post_status}' ) ";
		
		$create_post_query = mysqli_query($connection, $query);

		confirmQuery($create_post_query);

		$the_post_id = mysqli_insert_id($connection);

		echo "<p class='bg-success' style='padding: 10px'>Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>Edit Posts</a>";

	}
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="title">
	</div>
	<div class="form-group">
		<label for="post_category_id">Post Category </label>
		<select name="post_category" id="">
			<?php
				$query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);

                confirmQuery($select_categories);

                while ($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = escape($row['cat_id']);
                    $cat_title = escape($row['cat_title']);
                    echo "<option value='$cat_id'>{$cat_title}</option>";
                }
			?>

		</select>
	</div>
	<div class="form-group">
		<label for="author">Post Author</label>
		<select name="author" id="author">
            <?php

                $query = "SELECT * FROM users WHERE user_role = 'Admin' ";
                $select_user = mysqli_query($connection, $query);

                confirmQuery($select_user);

                while ($row = mysqli_fetch_assoc($select_user)) {
                    $user_id = escape($row['user_id']);
                    $username = escape($row['username']);
                    
                    if($username == $user_id){

                        echo "<option selected value='$username'>{$username}</option>";

                        } else {

                        echo "<option value='$username'>{$username}</option>";

                        }
                }
            ?>

        </select>
		<!-- <input type="text" class="form-control" name="author"> -->
	</div>
	<div class="form-group">
		<label for="post_status">Post Status</label>
		<select name="post_status" id="post_status">
            <option value="Draft">Draft</option>
            <option value="Published">Published</option>
        </select>
	</div>
	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image">
	</div>
	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>
	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_post" value="Create Post">
	</div>
</form>