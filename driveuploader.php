<?php
session_start();
include_once '../BrijrajGallery/src/Google_Client.php';
include_once '../BrijrajGallery/src/contrib/Google_Oauth2Service.php';
require_once '../BrijrajGallery/src/contrib/Google_DriveService.php';

$client = new Google_Client();
$client->setClientId('490422421383662|VPqCQDRFGZbGTSYvcUrKH5Ne4uw.apps.googleusercontent.com');
$client->setClientSecret('wWOj5J_Y_MDs104uCeUnaIgL');
$client->setRedirectUri('http://localhost/BrijrajGallery/driveuploader.php');
$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));


if (isset($_GET['code']) || (isset($_SESSION['access_token']))) {
	
	
	$service = new Google_DriveService($client);
    if (isset($_GET['code'])) {
		$client->authenticate($_GET['code']);
		$_SESSION['access_token'] = $client->getAccessToken();		
    } else
        $client->setAccessToken($_SESSION['access_token']);
	
    
    //uploading the zip file
    if (isset($_GET['filename']){
		$fileName=$_GET['filename'];
		$file = new Google_DriveFile();
		$file->setTitle($fileName);
		$file->setMimeType('application/zip');
		$file->setDescription('A User Details is uploading in json format');
    
	
		$createdFile = $service->files->insert($file, array(
          'data' =>file_get_contents('c:/Users/Nikhil/'),// file path
          'mimeType' => 'application/zip',
		  'uploadType'=>'multipart'
        ));
	}
   
    
		
	//unlink($fileName);
    header('location:home.php?fileNameupload=done');
	
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit();
}

?>