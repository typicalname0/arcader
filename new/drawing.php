<!DOCTYPE html>
<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/create.php");
?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - new drawing</title>
		<link rel="stylesheet" href="/static/css/main.css">
		<link rel="stylesheet" href="/static/css/profile.css">
        <script type="text/javascript" src="ritare/jscolor/jscolor.min.js"></script>
		<script type="text/javascript" src="ritare/ritare.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>
	<body>
		<div class="container">
			<?php
				require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");
				
				if(!isset($_SESSION['user'])) {
					die("You aren't logged in.");
				}
				
				if(@$_POST['submit']) {
					$title = htmlspecialchars($_POST['title']);
					$description = htmlspecialchars($_POST['description']);
					
					create('news', $title, $description, $_SESSION['user'], '', '', $conn);
				}
			?><br>
			<h1>new drawing</h1><br>
            <input required type="checkbox" name="remember"><small>This drawing will <b>NOT</b> break the Terms Of Service.</small><br>
            <input required type="checkbox" name="remember"><small>This drawing is not low effort.</small><br>
            Drawings are manually approved.<br>

            <div id="painter">
                <script type="text/javascript">
                    Ritare.start({
                        parentel: "painter",
                        onFinish: function(e) {
                            $.ajax({  
                                type: 'POST',  
                                url: 'handleArt.php', 
                                data: { drawing: Ritare.canvas.toDataURL('image/png') },
                                success: function(response) {
                                    alert(response);
                                    console.log(response);
                                }
                            });
                        },
                        width:600,
                        height:300
                    });
                </script>
            </div>
            <br>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>