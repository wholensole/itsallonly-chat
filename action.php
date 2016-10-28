<?php
	include ('functions.php');
	$action = $_REQUEST['action'];
	$message_time = get_timestamp();
	if (isset($_REQUEST['email'])) {
		$email = $_REQUEST['email'];
	}
	if (isset($_REQUEST['password'])) {
		$password = $_REQUEST['password'];
	}
	if (isset($_REQUEST['chat_handle'])) {
		$chat_handle = $_REQUEST['chat_handle'];
	}
	if (isset($_REQUEST['id'])) {
		$id = $_REQUEST['id'];
	}
	if (isset($_REQUEST['sender_id'])) {
		$sender_id = $_REQUEST['sender_id'];
	}
	if (isset($_REQUEST['receiver_id'])) {
		$receiver_id = $_REQUEST['receiver_id'];
	}
	if (isset($_REQUEST['message'])) {
		$message = $_REQUEST['message'];
	}
	if ((!isset($action))||($action == "")) {
		redirect('/login');
	}else{
		if ($action == 'login') {
			login($email, $password);
		}elseif ($action == 'register') {
			$email = $_REQUEST['email'];
			$chat_handle = $_REQUEST['chat_handle'];
			register($email, $chat_handle);
		}elseif ($action == 'forgot-password') {
			forgot_password($email);
		}elseif ($action == 'send-message') {
			send_message($message, $sender_id, $message_time);
		}elseif ($action == 'activate-user') {
			activate_user($id);
		}elseif ($action == 'deactivate-user') {
			deactivate_user($id);
		}elseif ($action == 'delete-user') {
			delete_user($id);
		}elseif ($action == 'delete-history') {
			delete_history();
		}elseif ($action == 'logout') {
			logout();
		}else {
			redirect('/login');
		}
	}
?>