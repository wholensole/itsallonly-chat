<?php
include('config.php');
function dbconnect() {
	$db = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	return $db;
}
function dbclose($db) {
	mysqli_close($db);
}
function login($email, $password) {
	$db = dbconnect();
    $s = "SELECT status FROM user WHERE (email = '$email' || chat_handle = '$email') AND password = '$password'";
    $result = mysqli_query($db, $s);
    $rows = mysqli_num_rows($result);
    if($rows == 1) {
        if (mysqli_query($db, $s)) {
        	$row = mysqli_fetch_assoc($result);
        	$status = $row['status'];
        	if ($status == 1) {
        		session_start();
				$_SESSION['email'] = $email;
	            if(is_admin($email)) {
	            	$_SESSION['session_area'] = 'admin-area';
	            	redirect(ADMIN_URL."?login-successful");
	            }
	            else{
	            	$_SESSION['session_area'] = 'user-area';
	            	redirect(SITE_URL."?login-successful");
	            }
        	}else {
        		redirect(SITE_URL."login?login-error-user-not-activated");
        	}
        }
        else {
            echo "Error: " . $s . "<br>" . mysqli_error(DB);
        }
    }
    else {
    	redirect(SITE_URL."login?login-error-no-user");
    }
    dbclose($db);
}
function logout() {
	session_start();
	unset($_SESSION['email']);
	unset($_SESSION['session_area']);
	session_destroy();
	redirect(SITE_URL);
}
function redirect($target) {
	header('Location: '.$target);
}
function register() {
	
}
function is_admin($email) {
	$s = "SELECT role FROM user WHERE email = '$email'";
	$db = dbconnect();
    $result = mysqli_query($db, $s);
    $row = mysqli_fetch_assoc($result);
    if($row["role"] == 'admin'){
    	$is_admin = true;
    }
    else{
    	$is_admin = false;
    }
    dbclose($db);
    return $is_admin;
}
function get_header() {
	include('header.php');
}
function get_footer() {
	include('footer.php');
}
function get_sidebar() {
	include('sidebar.php');
}
function get_stylesheet($file) {
	echo '<link rel="stylesheet" type="text/css" href="/'.$file.'.css?version='.get_version().'">';
}
function get_scriptsheet($file) {
	echo '<script type="text/javascript" src="/'.$file.'.js?version='.get_version().'"></script>';
}
function get_user_type() {
	
}
function the_user_id() {
	$email = $_SESSION['email'];
	$db = dbconnect();
	$s = "SELECT id FROM user WHERE email = '$email' || chat_handle = '$email'";
	$result = mysqli_query($db, $s);
    $user = mysqli_fetch_assoc($result);
	$user_id = $user['id'];
	dbclose($db);
	return $user_id;
}
function get_user_id() {
	$email = $_SESSION['email'];
	$db = dbconnect();
	$s = "SELECT id FROM user WHERE email = '$email' || chat_handle = '$email'";
	$result = mysqli_query($db, $s);
    $user = mysqli_fetch_assoc($result);
	$user_id = $user['id'];
	dbclose($db);
	echo $user_id;
}
function get_apple_icon($file) {
	echo '<link rel="apple-touch-icon image_src" href="'.$file.'">';
}
function get_favicon($file) {
	echo '<link rel="shortcut icon" href="'.$file.'">';
}
function get_version(){
	return VERSION;
}
function get_file($file) {
	$file = $file.".php";
	include('$file');
}
function get_home_url() {
	if (null !== HOME_URL) {
		$home_url = HOME_URL;
	}
	else {
		$s = "SELECT meta_value FROM options WHERE meta_key = 'home_url'";
		$db = dbconnect();
		$result = mysqli_query($db, $s);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
			$site = mysqli_fetch_assoc($result);
			$home_url = $site['home_url'];
		}
	}
	return $home_url;
}
function is_in_debug_mode(){
	if (null !== DEBUG) {
		$debug = DEBUG;
	}
	else {
		$s = "SELECT meta_value FROM options WHERE meta_key = 'debug'";
		$db = dbconnect();
		$result = mysqli_query($db, $s);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
			ini_set('display_errors', 1);
		}
		dbclose($db);
	}
}
function get_blog_url() {
	
}
function get_site_url() {
	if (null !== SITE_URL) {
		$site_url = SITE_URL;
	}
	else {
		$db = dbconnect();
		$s = "SELECT meta_value FROM options WHERE meta_key = 'site_url'";
		$result = mysqli_query($db, $s);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
			$site = mysqli_fetch_assoc($result);
			$site_url = $site['site_url'];
		}
		dbclose($db);
	}
	return $site_url;
}
function is_loggedin() {
	session_start();
	if (isset($_SESSION['email'])&&(isset($_SESSION['session_area']))) {
		$is_loggedin = true;
	}
	else{
		$is_loggedin = false;
	}
	return $is_loggedin;
}
function get_current_page() {
	$current_page = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return $current_page;
}
function get_timestamp(){
	$date = date_create();
	return date_timestamp_get($date);
}
function is_home() {
	$current_page = get_current_page();
	if ($current_page == SITE_URL) {
		$is_home = true;
	}else {
		$is_home = false;
	}
	return $is_home;
}
function get_aside_users_list() {

}
function get_messages() {
	$db = dbconnect();
	$s = "SELECT message, sender_id, message_time FROM public_msg WHERE 1";
	$result = mysqli_query($db, $s);
	if (mysqli_num_rows($result) > 0) {
	    while($message = mysqli_fetch_assoc($result)) {
	    	$msg = $message['message'];
	    	$sender_id = $message['sender_id'];
	    	$moment = $message['message_time'];
	    	$s = '<p class="message';
	    	$user_id = the_user_id();
	    	if ($user_id == $sender_id) {
	    		$s .= ' mine';
	    	}
	    	$s.= '">'.$msg.'<span class="moment">'.date('m/d/Y H:i:s', $moment).'</span></p>';
	    	echo $s;
	    }
	}
	echo '<p id="last"></p>';
}
function is_blog() {
	
}
function get_user_img() {

}
function get_user_full_name() {

}
function add_user() {
	
}
function delete_user() {
	
}
function get_title() {
	echo "ChatApp";
}
function send_message($message, $sender_id, $message_time) {
	$db = dbconnect();
    $s = "INSERT INTO public_msg (sender_id, message, message_time) VALUES ('$sender_id', '$message', '$message_time')";
    mysqli_query($db, $s);
    dbclose($db);
    redirect(SITE_URL);
}
?>