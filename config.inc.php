<?php
//   arcader configuration file.
//   Uncomment values by removing the // before changing!
	
    $config = array();

	$config['project_debug'] = true;
	$config['project_name'] = 'Arcader';
	$config['project_domain'] = 'spacemy.xyz';
	$config['project_owner'] = 'tydentlor';
	$config['project_discord'] = 'https://discord.gg/WjYeQNd';
	
	if($config['project_debug'] = true) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

        $config['recaptcha_secret'] = '';
	$config['recaptcha_sitekey'] = '';    
	$config['discord_webhook'] = '';
?>