<?php session_start(); ?>
<div class="headline">
	<a href="/"><h1 style="display: inline-block;"><?php echo $config['project_name']; ?></h1></a><span style="padding-top: 9px;padding-right: 5px;vertical-align: middle;" id="floatRight">
		<?php if(isset($_SESSION['user'])) { echo '<a href="/manage">edit profile</a>'; } ?> | <a href="/register">register</a> | <a href="/login">login</a>
	</span><br>
</div>
<span id="floatRight">logged in as <b>
	<?php
		if(isset($_SESSION['user'])) {
			echo $_SESSION['user'];
		} else {
			echo "Guest";
		}
	?>
</b></span><br>