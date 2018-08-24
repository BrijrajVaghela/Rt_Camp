<?php

	spl_autoload_register();

	$fb = new Facebook\Facebook([
	  'app_id' => '490422421383662',
	  'app_secret' => '4ffd82095e264a5d5db6779c4f2c076c',
	  'default_graph_version' => 'v3.1',
	  ]);

	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['email']; // optional
	
	$loginUrl = $helper->getLoginUrl('https://localhost/BrijrajGallery/home.php', $permissions);
	
	$logoutUrl = 'https://localhost/BrijrajGallery/login.php?logout=true';	
	
	$accessToken;
	
?>