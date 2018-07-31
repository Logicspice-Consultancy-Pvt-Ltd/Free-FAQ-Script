<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '754855524695734','2dcf98bbb8a87026eb3d039b697631a0' );

if(isset($_REQUEST['fbuse'])){
    $_SESSION['fbuse'] = $_REQUEST['fbuse'];
}

// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('https://www.dealerbaba.com/app/webroot/facebook/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me?locale=en_US&fields=id,name,email,first_name,last_name' );
  $response = $request->execute();
  // get response
            $graphObject = $response->getGraphObject();
     	    $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name');
            $femail = $graphObject->getProperty('email'); // To Get Facebook full name
            $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
            $first_name = $graphObject->getProperty('first_name');    // To Get Facebook email ID
            $last_name = $graphObject->getProperty('last_name');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	    $_SESSION['FB']['fbid'] = $fbid;           
            $_SESSION['FB']['fullname'] = $fbfullname;
	    $_SESSION['FB']['email'] =  $femail;
	    $_SESSION['FB']['first_name'] =  $first_name;
	    $_SESSION['FB']['last_name'] =  $last_name;
            
//            echo '<pre>';
//            print_r($_SESSION);exit;
            
    /* ---- header location after session ----*/
            if(isset($_SESSION['fbuse']) && $_SESSION['fbuse'] == 'connect'){
                header("Location: https://www.dealerbaba.com/users/fbconnect/");
            }else{
                header("Location: https://www.dealerbaba.com/users/fblogin/");
            }
  
  exit;
 
} else {
  $loginUrl = $helper->getLoginUrl();
 header("Location: ".$loginUrl);
}
?>