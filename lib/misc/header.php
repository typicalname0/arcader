<?php session_start(); ?>
<?php
    if(isset($_SESSION['user'])) {
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE username = ?");
        $stmt->bind_param("s", $_SESSION['user']);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if($result->num_rows == 0) die('welcome to gamestop how may i help you');
    }
?>
<div class="headline">
	<a href="/"><h1 class="inlineblock"><?php echo $config['project_name']; ?></h1></a><span id="headerthingy">
		| <?php if(isset($_SESSION['user'])) { echo '<a href="/logout">logout</a> | <a href="/manage">edit profile</a> | <a href="/following">fans</a> |'; } ?> <a href="/files">view all files</a> | <a href="/register">register</a> | <a href="/login">login</a>
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