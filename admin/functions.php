<?php
	function escape($string){
		global $connection;
		return mysqli_real_escape_string($connection, trim($string));
	}

	function users_online(){
		if (isset($_GET['onlineusers'])) {

			global $connection;
			if (!$connection) {
				session_start();
				include ("../includes/db.php");

				$session = session_id();
		        $time = time();
		        $time_out_in_seconds = 60;
		        $time_out = $time - $time_out_in_seconds;

		        $query = "SELECT * FROM users_online WHERE session = '$session'";
		        $send_query = mysqli_query($connection, $query);
		        $count = mysqli_num_rows($send_query);

		        if ($count == NULL) {
		            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
		        }else {
		            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
		        }
		        $users_online_query=mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
		        
		        echo $count_user = mysqli_num_rows($users_online_query);
			}
			
    	} //get request isset() end
	}
	users_online();

	function confirmQuery($result){
		global $connection;
		if(!$result) {
			die("Query Failed" . mysqli_error($connection));
		}
	}

	function insert_categories() {
		global $connection;
		if (isset($_POST['submit'])) {
		    $cat_title = escape($_POST['cat_title']);
		    if ($cat_title == "" || empty($cat_title)) {
		        echo "This field should not be empty.";
		    }
		    else {
		        $query = "INSERT INTO categories(cat_title)";
		        $query .= "VALUE('{$cat_title}')";

		        $create_category_query = mysqli_query($connection, $query);

		        if (!$create_category_query) {
		            die('QUERY FAILED' . mysqli_error($connection));
		        }
		    }
		}
	}

	function find_all_categories(){
		global $connection;
		$query = "SELECT * FROM categories";
	    $select_categories_query = mysqli_query($connection, $query);
	    while ($row = mysqli_fetch_assoc($select_categories_query)) {
	        $cat_id = escape($row['cat_id']);
	        $cat_title = escape($row['cat_title']);

	        echo "<tr>";
	        echo "<td>{$cat_id}</td>";
	        echo "<td>{$cat_title}</td>";
	        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
	        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
	        echo "</tr>";
	    }
	}

	function delete_categories(){
		global $connection;
		if (isset($_GET['delete'])) {
            $get_cat_id = escape($_GET['delete']);
            $query = "DELETE FROM categories WHERE cat_id = {$get_cat_id}";
            $delete_query = mysqli_query($connection, $query);
            header("Location: categories.php");
        }
	}

	function deleteComment() {
		global $connection;

		if (isset($_GET['delete'])) {
	        $the_comment_id = escape($_GET['delete']);

	        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
	        $delete_query = mysqli_query($connection, $query);
	        header("Location: post_comments.php?id=".escape($_GET['id'])."");
    	}
	}

	function visibleComment() {
		global $connection;

		if (isset($_GET['visible'])) {
	        $the_comment_id = escape($_GET['visible']);

	        $query = "UPDATE comments SET comment_status = 'Visible' WHERE comment_id = {$the_comment_id} ";
	        $disapprove_query = mysqli_query($connection, $query);
	        header("Location: post_comments.php?id=".escape($_GET['id'])."");
    	}
    }
	
	function invisibleComment() {
		global $connection;

		if (isset($_GET['invisible'])) {
	        $the_comment_id = escape($_GET['invisible']);

	        $query = "UPDATE comments SET comment_status = 'Invisible' WHERE comment_id = {$the_comment_id} ";
	        $approve_query = mysqli_query($connection, $query);
	        header("Location: post_comments.php?id=".escape($_GET['id'])."");
	    }
    }
	function recordCount($table) {
		global $connection;

		$query = "SELECT * FROM " . $table;
        $select_all_posts = mysqli_query($connection, $query);

        return mysqli_num_rows($select_all_posts);
	}

	function checkStatus($table, $column, $status){
		global $connection;

		$query = "SELECT * FROM $table WHERE $column = '$status'";
        $result = mysqli_query($connection, $query);
        return mysqli_num_rows($result);
	}
?>