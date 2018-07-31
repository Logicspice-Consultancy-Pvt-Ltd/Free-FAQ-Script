<?php

define('SITE_TITLE','LS FAQ script');
define('SITE_URL', 'http://localhost/faq_script');
define('ADMIN_TITLE', SITE_TITLE.' :: ');

define('TAG_LINE', "");
define('MAIL_FROM', 'info@faqscript.com');
define('TITLE_FOR_PAGES', " :: ".SITE_TITLE);

define('HTTP_PATH', 'http://localhost/faq_script');
define("BASE_PATH", $_SERVER['DOCUMENT_ROOT']);
define("HTTP_IMAGE",HTTP_PATH . '/webroot/img');


/* * ***************************** User Image Path Start ****************************** */
define('UPLOAD_FULL_PROFILE_IMAGE_PATH', BASE_PATH . '/webroot/files/users/full/');
define('UPLOAD_THUMB_PROFILE_IMAGE_PATH', BASE_PATH . '/webroot/files/users/thumb/');
define('UPLOAD_SMALL_PROFILE_IMAGE_PATH', BASE_PATH . '/webroot/files/users/small/');

define('UPLOAD_THUMB_PROFILE_IMAGE_WIDTH', 290);
define('UPLOAD_THUMB_PROFILE_IMAGE_HEIGHT', '');
define('UPLOAD_SMALL_PROFILE_IMAGE_WIDTH', 80);
define('UPLOAD_SMALL_PROFILE_IMAGE_HEIGHT', '');

define('DISPLAY_FULL_PROFILE_IMAGE_PATH', HTTP_PATH . '/webroot/files/users/full/');
define('DISPLAY_THUMB_PROFILE_IMAGE_PATH', HTTP_PATH . '/webroot/files/users/thumb/');
define('DISPLAY_SMALL_PROFILE_IMAGE_PATH', HTTP_PATH . '/webroot/files/users/small/');

/* * ***************************** User Image Path End ****************************** */

/* * ***************************** Home Background Image Path ****************************** */
define('UPLOAD_BG_IMAGE_PATH', BASE_PATH . '/webroot/files/backgrounds/');
define('DISPLAY_BG_IMAGE_PATH', HTTP_PATH . '/webroot/files/backgrounds/');

/* * ***************************** Page Image Path ****************************** */
define('UPLOAD_PAGES_IMAGE_PATH', BASE_PATH . '/webroot/files/uploadimages/');
define('DISPLAY_PAGES_IMAGE_PATH', HTTP_PATH . '/webroot/files/uploadimages/');

global $imageextentions;
$imageextentions = array(
    'jpg' => 'jpg',
    'jpeg' => 'jpeg',
    'gif' => 'gif',
    'png' => 'png'
);
?>