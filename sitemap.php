<!DOCTYPE html>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); ?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - index</title>
		<link rel="stylesheet" href="/static/css/main.css">
	</head>
	<body>
		<div class="container">
			<?php
				require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");
			?>
			<h1>sitemap</h1>
            <div class="PrintingStyle" id="PrintStyleID" style="height:100%;width:100%"><ul id="root"><li class="open"><a class="open" href="#" onclick="return toggleExpando(this)" aria-label="Expand"><img class="open" src="/static/img/iedoc.gif" alt="" width="18" height="18"></a><a href="/" class="page">Arcader - index</a><ul><li class="open"><a><img class="open" src="/static/img/iedoc.gif" alt="" width="18" height="18"></a><a href="/files" class="page">Arcader - files</a></li><li class="open"><a><img class="open" src="/static/img/iedoc.gif" alt="" width="18" height="18"></a><a href="/register" class="page">Arcader - register</a></li><li class="open"><a><img class="open" src="/static/img/iedoc.gif" alt="" width="18" height="18"></a><a href="/login" class="page">Arcader - login</a></li><li class="open"><a><img class="open" src="/static/img/iedoc.gif" alt="" width="18" height="18"></a><a href="/new/video" class="page">Arcader - new video</a></li><li class="open"><a><img class="open" src="/static/img/iedoc.gif" alt="" width="18" height="18"></a><a href="/new/image" class="page">Arcader - new image</a></li><li class="open"><a><img class="open" src="/static/img/iedoc.gif" alt="" width="18" height="18"></a><a href="/new/news" class="page">Arcader - new news</a></li><li class="open"><a><img class="open" src="/static/img/iedoc.gif" alt="" width="18" height="18"></a><a href="/new/game" class="page">Arcader - new game</a></li><li class="open"><a><img class="open" src="/static/img/iedoc.gif" alt="" width="18" height="18"></a><a href="/view/profile" class="page">Arcader - profile</a></li><li class="open"><a><img class="open" src="/static/img/iedoc.gif" alt="" width="18" height="18"></a><a href="/" class="page">Arcader - ?</a></li></ul></li></ul></div>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>
