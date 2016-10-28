<?php
	include ('functions.php');
	get_header();
	if (!is_loggedin()) {
		redirect('/login');
	}else{
		?>
			<header>
				<div class="user-info">
					<img src="<?php get_user_img();?>" class="user-img" />
					<span class="user-name"><?php get_user_full_name();?></span>
				</div>
				<form class="logout-button" action="action.php" method="post">
					<input type="hidden" name="action" value="logout" />
					<button class="action-link" type="submit"><img src="/images/logout.png" /></button>
				</form>
				<button class="action-link reload-button" onClick="window.location.reload()"><img src="/images/reload.png" /></button>
				<div class="clearfix"></div>
			</header>
			<aside>
				<ul class="user-list">
					<?php get_aside_users_list();?>
				</ul>
			</aside>
			<main id="main">
				<?php
					get_messages();
				?>
			</main>
			<footer>
				<form class="add-message-form" action="action.php" method="post">
					<input type="hidden" name="action" value="send-message" />
					<input type="hidden" name="sender_id" value="<?php get_user_id();?>" />
					<input type="text" name="message" placeholder="Type your message here" class="message-box" required autofocus />
					<button class="message-link" type="submit"><span class="icon-send-message"></span></button>
					<div class="clearfix"></div>
				</form>
			</footer>
		<?php
	}
	get_footer();
?>