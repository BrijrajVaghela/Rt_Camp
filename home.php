<?php

session_start();

if(isset($_REQUEST['logout']))
{
	session_destroy();
	header('Location: https://localhost/BrijrajGallery/login.php?logout=true');	
}

	require_once("jsonparser.php");
	require_once("imagecontroller.php");
	
	spl_autoload_register();

	$fb = new Facebook\Facebook([
	   'app_id' => '490422421383662',
	  'app_secret' => '4ffd82095e264a5d5db6779c4f2c076c',
	  'default_graph_version' => 'v3.1',
	  ]);

	$helper = $fb->getRedirectLoginHelper();
	$logoutUrl = 'https://localhost/BrijrajGallery/home.php?logout=true';	
	$accessToken;	
	
	
	
try {
	if(isset($_SESSION['facebook_access_token'])) {
		$GLOBALS['accessToken']= $_SESSION['facebook_access_token'];
	} else {
		$GLOBALS['accessToken'] ="EAACJn6Hj36sBAPO3s6XiF0jZAlak39xWjruBxcbIdVmhrIORK0fTbTVR594glqhL1akG8X7u89Im1G1dts31P5QBjo7t1zgPfVBejhDZCrglkiW1rgyojYRsx6ZCb4hbPM2WmZCmxayJ0mpdUznxcyG9szK5KtQGEIivIqyyOZCqpCaABMRLExO89Hxj8z20ZD";
		//$GLOBALS['accessToken'] = $helper->getAccessToken();
	}
	//echo $accessToken;
	//exit;
}
catch(Facebook\Exceptions\FacebookResponseException $e){//Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo "Facebook SDK returned an error:".$e->getMessage();
	echo '<hr/><a href="'.$logoutUrl.'">Back To Main Page</a>';
  	exit;
 }

if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
		
	} else {
		// getting short-lived access token
		$_SESSION['facebook_access_token'] = (string) $accessToken;

	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();

		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}

	// redirect the user back to the same page if it has "code" GET variable
	 ob_start();
	if (!isset($_GET['code'])) {
		header('Location: https://localhost/nikgallery/login.php?fbcode=isnotset');
	}

	// getting basic info about user
	try {
		  $profile_request = $fb->get('me?fields=id,name,email,birthday,cover,picture,hometown,age_range,gender,location,albums.limit(100){count,name,photos{images}}',$accessToken);
		
		  $profile = $profile_request->getGraphNode()->asArray();
			
		  //udfRecursiveTraverse($profile);
		  //echo "<hr/>";
		  //exit;
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		header("Location: https://localhost/BrijrajGallery/login.php?lol2=ababba");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		echo '<a href="https://localhost/nikgallery/login.php?logout=true">Back</a>';
		exit;
	}
	
	// printing $profile array on the screen which holds the basic info about user
	
	//print_r($profile);
	//echo '<hr/>';
    //echo $profile['email'];
  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
	header("Location:https://localhost/BrijrajGallery/login.php?final=hahaha");
}
?>

<!DOCTYPE html>
<html>
<title>FaceBook Gallery</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="./images/fb.png" type="image/png" sizes="16x16">
<link rel="stylesheet" href="./css/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/specialtitle.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Open Sans", sans-serif}
</style>
<body class="w3-theme-l5">
<form method="GET" action="imagecontroller.php">
<!-- Navbar -->
<div class="w3-top">
 <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i><i class="fa fa-facebook"></i><span><b>aceBook</b></span></a>
  <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="News"><i class="fa fa-globe"></i></a>
  <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Account Settings"><i class="fa fa-user"></i></a>
  <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Messages"><i class="fa fa-envelope"></i></a>
  <div class="w3-dropdown-hover w3-hide-small">
    <button class="w3-button w3-padding-large" title="Notifications"><i class="fa fa-bell"></i><span class="w3-badge w3-right w3-small w3-green">3</span></button>     
    <div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:300px">
      <!--<a href="#" class="w3-bar-item w3-button">One new friend request</a>
      <a href="#" class="w3-bar-item w3-button">John Doe posted on your wall</a>
      <a href="#" class="w3-bar-item w3-button">Jane likes your post</a>-->
    </div>
  </div>
  
  <div class="w3-dropdown-hover w3-right">
    <button class="w3-button"><img src="./images/avatar2.png" class="w3-circle" style="height:23px;width:23px" alt="Avatar"></button>
    <div class="w3-dropdown-content w3-bar-block w3-border" style="right:0">
      <!--<a href="#" class="w3-bar-item w3-button">Logout</a>-->
	  <?php echo '<b><a href="' . $logoutUrl . '" class="w3-bar-item w3-button">Logout</a></b>'; ?>
    </div>
  </div>
 </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 1</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 2</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 3</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">My Profile</a>
</div>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white">
        <div class="w3-container">
         <h4 class="w3-center"><?php echo $profile['name']; ?></h4>
         <p class="w3-center"><img src="<?php echo $profile['picture']['url'];?>" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
         <hr>
         <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Designer, UI</p>
         <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i>Gujarat, <?php echo $profile['hometown']['name']; ?></p>
         <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i><?php $Date = $profile['birthday']->format('j-F-Y'); echo $Date; ?></p>
		 <p><i class="fa fa-envelope fa-fw w3-margin-right w3-text-theme"></i><?php echo $profile['email'] ?></p>
		</div>
      </div>
      <br>
      
      <!-- Accordion -->
      <div class="w3-card w3-round">
        <div class="w3-white">
          <p onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> My Info</p>
          <div id="Demo1" class="w3-hide w3-container">
            <p><?php echo "Gender: ".$profile['gender']."<hr/>"."Age: ".$profile['age_range']['min'];?></p>
          </div>
          <p onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> My Events</p>
          <div id="Demo2" class="w3-hide w3-container">
            <p>Some other text..</p>
          </div>
          <p onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> My Photos</p>
          <div id="Demo3" class="w3-hide w3-container">
			 <div class="w3-row-padding">
			 <br>
			   <div class="w3-half">
				 <img src="./images/lights.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			   <div class="w3-half">
				 <img src="./images/nature.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			   <div class="w3-half">
				 <img src="./images/mountains.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			   <div class="w3-half">
				 <img src="./images/forest.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			   <div class="w3-half">
				 <img src="./images/nature.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			   <div class="w3-half">
				 <img src="./images/fjords.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			 </div>
          </div>
        </div>      
      </div>
      <br>
      
      <!-- Interests 
      <div class="w3-card w3-round w3-white w3-hide-small">
        <div class="w3-container">
          <p>Interests</p>
          <p>
            <span class="w3-tag w3-small w3-theme-d5">News</span>
            <span class="w3-tag w3-small w3-theme-d4">W3Schools</span>
            <span class="w3-tag w3-small w3-theme-d3">Labels</span>
            <span class="w3-tag w3-small w3-theme-d2">Games</span>
            <span class="w3-tag w3-small w3-theme-d1">Friends</span>
            <span class="w3-tag w3-small w3-theme">Games</span>
            <span class="w3-tag w3-small w3-theme-l1">Friends</span>
            <span class="w3-tag w3-small w3-theme-l2">Food</span>
            <span class="w3-tag w3-small w3-theme-l3">Design</span>
            <span class="w3-tag w3-small w3-theme-l4">Art</span>
            <span class="w3-tag w3-small w3-theme-l5">Photos</span>
          </p>
        </div>
      </div>
      <br>--> 
      
      <!-- Alert Box 
      <div class="w3-container w3-display-container w3-round w3-theme-l4 w3-border w3-theme-border w3-margin-bottom w3-hide-small">
        <span onclick="this.parentElement.style.display='none'" class="w3-button w3-theme-l3 w3-display-topright">
          <i class="fa fa-remove"></i>
        </span>
        <p><strong>Hey!</strong></p>
        <p>People are looking at your profile. Find out who.</p>
      </div>-->
    
    <!-- End Left Column -->
    </div>
    
    <!-- Middle Column -->
    <div class="w3-col m8">
    
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
             <!-- <h6 class="w3-opacity">Social Media template by w3.css</h6>
              <p contenteditable="true" class="w3-border w3-padding">Status: Feeling Blue</p>-->
              <center><button type="button" id="btnopen" class="w3-button w3-theme"><i class="fa fa-camera"> </i> Click To Download Specific Pictures</button> </center>
            </div>
          </div>
        </div>
      </div>
      
      <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
        <i class="icon-large icon-camera-retro icon-4x"></i><h4 class="w3-card w3-round" id="specialtitle">FaceBook Albums</h4>
        <hr class="w3-clear">
		<div id="main" class="col-sm-12">
			<div class="row">
			  <div class="panel-group">
				<?php 
					udfRecursiveTraversefor_individual_album_pic();
				?>
			  </div>
			</div>
			<div id="gallery" class="row">
			<?php 
				udfRecursiveTraverseforalbum();
			?>
			</div>
			<div>
			<hr/>
				<center><button type="submit" id="submit" name="submit" class="w3-button w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i> Download Albums</button></center> 
			</div>
			<div id="for_spcific_pic">
			<hr/>
				<center><button type="submit" id="btn_individual_download" name="btn_individual_download" class="w3-button w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i>Download Selected Pictures</button></center> 
			</div>
		</div>
      </div>
      <!--
      <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
        <img src="./images/avatar5.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
        <span class="w3-right w3-opacity">16 min</span>
        <h4>Jane Doe</h4><br>
        <hr class="w3-clear">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <button type="button" class="w3-button w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i>  Like</button> 
        <button type="button" class="w3-button w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i>  Comment</button> 
      </div>  

      <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
        <img src="./images/avatar6.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
        <span class="w3-right w3-opacity">32 min</span>
        <h4>Angie Jane</h4><br>
        <hr class="w3-clear">
        <p>Have you seen this?</p>
        <img src="./images/nature.jpg" style="width:100%" class="w3-margin-bottom">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <button type="button" class="w3-button w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i>  Like</button> 
        <button type="button" class="w3-button w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i>  Comment</button> 
      </div> -->
      
    <!-- End Middle Column -->
    </div>
    
  </div>
  
<!-- End Page Container -->
</div>
<br>

<!-- Footer -->
<footer class="w3-container w3-theme-d3 w3-padding-16">
  <center><h5><u>Designed By</u> : Brijrajsinh Vaghela - 16MCA054 </h5></center>
</footer>
<footer class="w3-container w3-theme-d5">
  <center><p>Powered by <a href="#" target="_blank">FaceBook Gallery</a></p></center>
</footer>
 
<script>
// Accordion
function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-theme-d1";
		
    } else { 
        x.className = x.className.replace("w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-theme-d1", "");
    }
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
$(function(){
    $("#btnopen").click(function(){
		$("#submit").slideToggle("fast");
		$("#for_spcific_pic").slideToggle("fast");
        $("#gallery").slideToggle("slow");
		$(".panel-info").slideToggle("slow");
    });
	$(document.body).click(function(evt){
			var currentID = evt.target.id || "No ID!";
				currentID="#"+currentID;
			if(currentID.indexOf("panelhead") >= 0)
			{$(currentID).next().slideToggle("slow");}
	})
});
</script>
</form>
</body>
</html> 
