<?php
namespace Cake\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Utility\CookieCryptTrait;
use Cake\Utility\Hash;
use Cake\Utility\Security;

class PImageComponent extends Component
{
	/*
	 * PImageComponent: component to resize or crop images
	 * @author: Wendy Perkins aka The Perkster
 	 * @website: http://www.perksterdesigns.com/  - Probably still not up to par
 	 * @license: MIT
 	 * @version: 0.8.3.1
	 */

	/*
	 * @param $cType - the conversion type: resize (default), resizeCrop (square), crop (from center)
	 * @param $id - image filename
	 * @param $imgFolder  - the folder where the image is
	 * @param $newName - include extension (if desired)
	 * @param $newWidth - the  max width or crop width
	 * @param $newHeight - the max height or crop height
	 * @param $quality - the quality of the image
	 * @param $bgcolor - this was from a previous option that was removed, but required for backward compatibility
	 */

	function resizeImage($cType = 'resize', $id, $imgFolder, $newName = false, $newWidth=false, $newHeight=false, $quality = 75, $bgcolor = false)
	{
		 $img = $imgFolder . $id;

		list($oldWidth, $oldHeight, $type) = getimagesize($img);
		$ext = $this->image_type_to_extension($type);

		//check to make sure that the file is writeable, if so, create destination image (temp image)
//                echo $imgFolder."<br />"; exit;

		if (is_writeable($imgFolder))
		{
			if($newName){
				$dest = $imgFolder . $newName;
			} else {
				$dest = $imgFolder . 'tmp_'.$id;
			}
		}
		else
		{
			//if not let developer know
			$imgFolder = substr($imgFolder, 0, strlen($imgFolder) -1);
			$imgFolder = substr($imgFolder, strrpos($imgFolder, '\\') + 1, 20);
			debug("You must allow proper permissions for image processing. And the folder has to be writable.");
			debug("Run \"chmod 777 on '$imgFolder' folder\"");
			exit();
		}

		//check to make sure that something is requested, otherwise there is nothing to resize.
		//although, could create option for quality only
		if ($newWidth OR $newHeight)
		{
			/*
			 * check to make sure temp file doesn't exist from a mistake or system hang up.
			 * If so delete.
			 */
			if(file_exists($dest))
			{
				unlink($dest);
			}
			else
			{
				switch ($cType){
					default:
					case 'resize':
						# Maintains the aspect ration of the image and makes sure that it fits
						# within the maxW(newWidth) and maxH(newHeight) (thus some side will be smaller)
						$widthScale = 2;
						$heightScale = 2;

						if($newWidth) $widthScale = 	$newWidth / $oldWidth;
						if($newHeight) $heightScale = $newHeight / $oldHeight;
						//debug("W: $widthScale  H: $heightScale<br>");
						if($widthScale < $heightScale) {
							$maxWidth = $newWidth;
							$maxHeight = false;
						} elseif ($widthScale > $heightScale ) {
							$maxHeight = $newHeight;
							$maxWidth = false;
						} else {
							$maxHeight = $newHeight;
							$maxWidth = $newWidth;
						}

						if($maxWidth > $maxHeight){
							$applyWidth = $maxWidth;
							$applyHeight = ($oldHeight*$applyWidth)/$oldWidth;
						} elseif ($maxHeight > $maxWidth) {
							$applyHeight = $maxHeight;
							$applyWidth = ($applyHeight*$oldWidth)/$oldHeight;
						} else {
							$applyWidth = $maxWidth;
								$applyHeight = $maxHeight;
						}
						//debug("mW: $maxWidth mH: $maxHeight<br>");
						//debug("aW: $applyWidth aH: $applyHeight<br>");
						$startX = 0;
						$startY = 0;
						//exit();
						break;
					case 'resizeCrop':
						// -- resize to max, then crop to center
						$ratioX = $newWidth / $oldWidth;
						$ratioY = $newHeight / $oldHeight;

						if ($ratioX < $ratioY) {
							$startX = round(($oldWidth - ($newWidth / $ratioY))/2);
							$startY = 0;
							$oldWidth = round($newWidth / $ratioY);
							$oldHeight = $oldHeight;
						} else {
							$startX = 0;
							$startY = round(($oldHeight - ($newHeight / $ratioX))/2);
							$oldWidth = $oldWidth;
							$oldHeight = round($newHeight / $ratioX);
						}
						$applyWidth = $newWidth;
						$applyHeight = $newHeight;
						break;
					case 'crop':
						// -- a straight centered crop
						$startY = ($oldHeight - $newHeight)/2;
						$startX = ($oldWidth - $newWidth)/2;
						$oldHeight = $newHeight;
						$applyHeight = $newHeight;
						$oldWidth = $newWidth;
						$applyWidth = $newWidth;
						break;
				}

				switch($ext)
				{
					case 'gif' :
						$oldImage = imagecreatefromgif($img);
						break;
					case 'png' :
						$oldImage = imagecreatefrompng($img);
						break;
					case 'jpg' :
					case 'jpeg' :
						$oldImage = imagecreatefromjpeg($img);
						break;
					default :
						//image type is not a possible option
						return false;
						break;
				}

				//create new image
				$newImage = imagecreatetruecolor($applyWidth, $applyHeight);

				if($bgcolor):
				//set up background color for new image
					sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
					$newColor = ImageColorAllocate($newImage, $red, $green, $blue);
					imagefill($newImage,0,0,$newColor);
				endif;

				//put old image on top of new image
				imagecopyresampled($newImage, $oldImage, 0,0 , $startX, $startY, $applyWidth, $applyHeight, $oldWidth, $oldHeight);

					switch($ext)
					{
						case 'gif' :
							imagegif($newImage, $dest, $quality);
							break;
						case 'png' :
							imagepng($newImage, $dest, $quality);
							break;
						case 'jpg' :
						case 'jpeg' :
							imagejpeg($newImage, $dest, $quality);
							break;
						default :
							return false;
							break;
					}

				imagedestroy($newImage);
				imagedestroy($oldImage);

				if(!$newName){
					unlink($img);
					rename($dest, $img);
				}

				return true;
			}

		} else {
			return false;
		}


	}

	function image_type_to_extension($imagetype)
	{
	if(empty($imagetype)) return false;
		switch($imagetype)
		{
			case IMAGETYPE_GIF    : return 'gif';
			case IMAGETYPE_JPEG    : return 'jpg';
			case IMAGETYPE_PNG    : return 'png';
			case IMAGETYPE_SWF    : return 'swf';
			case IMAGETYPE_PSD    : return 'psd';
			case IMAGETYPE_BMP    : return 'bmp';
			case IMAGETYPE_TIFF_II : return 'tiff';
			case IMAGETYPE_TIFF_MM : return 'tiff';
			case IMAGETYPE_JPC    : return 'jpc';
			case IMAGETYPE_JP2    : return 'jp2';
			case IMAGETYPE_JPX    : return 'jpf';
			case IMAGETYPE_JB2    : return 'jb2';
			case IMAGETYPE_SWC    : return 'swc';
			case IMAGETYPE_IFF    : return 'aiff';
			case IMAGETYPE_WBMP    : return 'wbmp';
			case IMAGETYPE_XBM    : return 'xbm';
			default                : return false;
		}
	}


function upload($fileArray, $folder="", $types="") {

    if(!$fileArray['name']) return array('','No file specified');
    $file_title = $fileArray['name'];

    //Get file extension

    $ext_arr = explode(".",basename($file_title));

    $ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension



    //Not really uniqe - but for all practical reasons, it is

    $uniqer = substr(md5(uniqid(rand(),1)),0,5);

    $file_name = $uniqer . '_' . $file_title;//Get Unique Name



    $all_types = explode(",",strtolower($types));

    if($types) {

        if(in_array($ext,$all_types));

        else {

            $result = "'".$fileArray['name']."' is not a valid file."; //Show error if any.

            return array('',$result);

        }

    }



    //Where the file must be uploaded to

    if($folder) $folder .= '/';//Add a '/' at the end of the folder

    $uploadfile = $folder . $file_name;
//    echo $uploadfile; exit;


    $result = '';

    //Move the file from the stored location to the new location
//    echo $uploadfile."<br />";
//    echo $fileArray['tmp_name'];
//    exit;
    if (!move_uploaded_file($fileArray['tmp_name'], $uploadfile)) {

        $result = "Cannot upload the file '".$fileArray['name']."'"; //Show error if any.

        if(!file_exists($folder)) {

		echo $folder;
            $result .= " : Folder don't exist.";

        } elseif(!is_writable($folder)) {

            $result .= " : Folder not writable.";

        }
        elseif(!is_writable($uploadfile)) {

            $result .= " : File not writable.";

        }

        $file_name = '';



    } else {

        if(!$fileArray['size']) { //Check if the file is made

            @unlink($uploadfile);//Delete the Empty file

            $file_name = '';

            $result = "Empty file found - please use a valid file."; //Show the error message

        } else {

            chmod($uploadfile,0777);//Make it universally writable.

        }

    }

//	print_r(array($file_name,$result));
    return array($file_name,$result);

}


//--------------------Image Upload------------------------------//
function imageUpload11($fileFieldId, $imgPrefix="", $destPath, $widthRS)
{

                         //echo $widthRS;exit;
				//$pext = getFileExtension($_FILES['imgfile1']['name']);
						//print_r($_FILES[$fileFieldId]);
					//echo $destPath;exit;
						$str = $_FILES[$fileFieldId]['name'];
						$i = strrpos($str,".");
						if (!$i) { return ""; }
						$l = strlen($str) - $i;
						$pext = substr($str,$i+1,$l);
						$pext = strtolower($pext);
						/*if (($pext != "jpg")   && ($pext != "gif")  &&  ($pext != "jpeg")   )
						{
							print "<h1>ERROR</h1>Image Extension Unknown.<br>";
							print "<p>Please upload only a JPG, JPEG, GIF image with the extension .jpg, .jpeg  or .gif ONLY<br><br>";
							print "The file you uploaded had the following extension: $pext</p>\n";
							return;
						}*/
						$temp=$temp;
						$temp.=$imgPrefix;
						//$temp.=".$pext";
						$final_filename = $temp;
						$nameToReturn = $final_filename;
						$newfile = $destPath . $final_filename;
						$newfile_small=LEAGUE_UPLOAD_SMALL_IMG_PATH.$final_filename;

					 #------------------------------------ ----  Uplaode Image  Full size  ---- --------------------------#

					if (is_uploaded_file($_FILES[$fileFieldId]['tmp_name']))
					{
						 if (!copy($_FILES[$fileFieldId]['tmp_name'], $newfile))
						 {
							 print "Error Uploading File.";
							 return;
						 }
                                                 if (!copy($_FILES[$fileFieldId]['tmp_name'], $newfile_small))
						 {
							 print "Error small image Uploading File.";
							 return;
						 }

					}

					 $imageResize = $newfile;
						if (is_uploaded_file($_FILES[$fileFieldId]['tmp_name']))
						{
							 if (!copy($_FILES[$fileFieldId]['tmp_name'], $imageResize))
							{
								print "Error Uploading File.";
								exit();
							}
						}
					$uploadedfile = $_FILES[$fileFieldId]['tmp_name'];
					$src="";
					if(($pext == "jpg")  ||  ($pext == "jpeg")){
						$src = imagecreatefromjpeg($uploadedfile);
					}
					if(($pext == "gif") ){
						$src = imagecreatefromgif($uploadedfile);
					}
					if(($pext == "png") ){
						$src = imagecreatefrompng($uploadedfile);
					}

					 #------------------------------------ ---- Code Resize Image      ---------------------------#

						list($width,$height)=getimagesize($uploadedfile);

					#------------------------------------Thumbnil size Image size reduce  ---------------------------#
//					//echo $width .">". $widthRS;exit;
//					if($width > $widthRS)
//						{
//							$newheight=($widthRS/$width)*$height;
//							$newwidth=$widthRS;
//						} else {
//							$newheight=$height;
//							$newwidth=$width;
//						}


					 #------------------------------------Thumbnil size Image size reduce  ---------------------------#
//						$tmpee=imagecreatetruecolor($newwidth,$newheight);

//                                                if( ($pext == 'png') || ($pext == "gif") )
//                                                    {
//                                                        $transparentColor = imagecolorallocatealpha($tmpee, 232, 232, 232, 127);
//                                                        imagefill($tmpee, 0, 0, $transparentColor);
//                                                        //print 'here';exit;
//                                                    }


//						imagecopyresampled($tmpee,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
//						$thumbfilename_main =  $imageResize ;


//                                                $trnprt_indx = imagecolorallocate($tmpee, 0, 0, 0);
//                                                imagecolortransparent($tmpee, $trnprt_indx);

						imagejpeg($tmpee,getimagesize($uploadedfile),100);
						imagedestroy($src);
						imagedestroy($tmpee);


					return $nameToReturn;
	} // end of function imageUpload()




// Function for League Image Upload
function imageCorrectUploadResize($fileFieldId, $imgPrefix="", $destPath, $widthRS, $sourceImagePath){
//  echo "Rajeev";exit;
//    print('<pre>');
//    print_r($fileFieldId);
//    print('<br>');
//    print_r($imgPrefix);
//    print('<br>');
//    print_r($destPath);
//    print('<br>');
//    print_r($widthRS);
//    print('<br>');
//    print_r($sourceImagePath);
//    print('<br>');
//    echo "Rajeev Image correct";exit;

    $str =$fileFieldId['name'];
						$i = strrpos($str,".");
						if (!$i) { return ""; }
						$l = strlen($str) - $i;
						$pext = substr($str,$i+1,$l);
						$pext = strtolower($pext);
						$temp=null;
						$temp.=$imgPrefix;
						$temp.=".$pext";
						$final_filename = $temp;
						$nameToReturn = $final_filename;
						$newfile = $destPath . $final_filename;
						$newfile_small=$destPath.$final_filename;
                        $newfile_largesource = $sourceImagePath.$final_filename;

					 #------------------------------------ ----  Uplaode Image  Full size  ---- --------------------------#

					if (is_uploaded_file($fileFieldId['tmp_name']))
					{
						 if (!copy($fileFieldId['tmp_name'], $newfile))
						 {
							 print "Error Uploading File.";
							 return;
						 }
                                                 if (!copy($fileFieldId['tmp_name'], $newfile_small))
						 {
							 print "Error small image Uploading File.";
							 return;
						 }

					}

					 $imageResize = $newfile;
						if (is_uploaded_file($fileFieldId['tmp_name']))
						{
							 if (!copy($fileFieldId['tmp_name'], $imageResize))
							{
								print "Error Uploading File.";
								exit();
							}
						}
					$uploadedfile = $fileFieldId['tmp_name'];

					$src="";
					if(($pext == "jpg")  ||  ($pext == "jpeg")){
						$src = imagecreatefromjpeg($uploadedfile);
					}
					if(($pext == "gif") ){
						$src = imagecreatefromgif($uploadedfile);
					}
					if(($pext == "png") ){
						$src = imagecreatefrompng($uploadedfile);
					}

					 #------------------------------------ ---- Code Resize Image      ---------------------------#

						list($width,$height)=getimagesize($uploadedfile);

					#------------------------------------Thumbnil size Image size reduce  ---------------------------#
					//echo $width .">". $widthRS;exit;
					if($width > $widthRS)
						{
							$newheight=($widthRS/$width)*$height;
							$newwidth=$widthRS;
						} else {
							$newheight=$height;
							$newwidth=$width;
						}
                            $newheight=intval($newheight);
							$newwidth=intval($newwidth);

//                    print_r($newheight);
//                    print_r($newwidth);
//                    echo "Rajeev";exit;

                    $this->smart_resize_image($newfile_largesource,$newwidth,$newheight,false,$newfile,false,true);

					return $nameToReturn;
                  //exit;

}




function smart_resize_image( $file, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false )
  {
    if ( $height <= 0 && $width <= 0 ) {
      return false;
    }
//    print('<pre>');
//    print_r($file);
//    print('<br>');
//    print_r($width);
//    print('<br>');
//    print_r($proportional);
//    print('<br>');
//    print_r($output);
//    print('<br>');
//    print_r($delete_original);
//    print('<br>');
//    print_r($use_linux_commands);
//    print('<br>');
//    echo "Rajeev Image123";exit;


    $info = getimagesize($file);
    $image = '';

    $final_width = 0;
    $final_height = 0;
    list($width_old, $height_old) = $info;

    if ($proportional) {
      if ($width == 0) $factor = $height/$height_old;
      elseif ($height == 0) $factor = $width/$width_old;
      else $factor = min ( $width / $width_old, $height / $height_old);

      $final_width = round ($width_old * $factor);
      $final_height = round ($height_old * $factor);

    }
    else {
      $final_width = ( $width <= 0 ) ? $width_old : $width;
      $final_height = ( $height <= 0 ) ? $height_old : $height;
    }
//                         echo $final_width;
//                      echo '<br>';
//                      echo $final_height;
//                      exit;


    switch ( $info[2] ) {
      case IMAGETYPE_GIF:
        $image = imagecreatefromgif($file);
      break;
      case IMAGETYPE_JPEG:
        $image = imagecreatefromjpeg($file);
      break;
      case IMAGETYPE_PNG:
        $image = imagecreatefrompng($file);
      break;
      default:
        return false;
    }

    $image_resized = imagecreatetruecolor( $final_width, $final_height );

    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
      $trnprt_indx = imagecolortransparent($image);

      // If we have a specific transparent color
      if ($trnprt_indx >= 0) {

        // Get the original image's transparent color's RGB values
        $trnprt_color    = imagecolorsforindex($image, $trnprt_indx);

        // Allocate the same color in the new image resource
        $trnprt_indx    = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

        // Completely fill the background of the new image with allocated color.
        imagefill($image_resized, 0, 0, $trnprt_indx);

        // Set the background color for new image to transparent
        imagecolortransparent($image_resized, $trnprt_indx);


      }
      // Always make a transparent background color for PNGs that don't have one allocated already
      elseif ($info[2] == IMAGETYPE_PNG) {

        // Turn off transparency blending (temporarily)
        imagealphablending($image_resized, false);

        // Create a new transparent color for image
        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);

        // Completely fill the background of the new image with allocated color.
        imagefill($image_resized, 0, 0, $color);

        // Restore transparency blending
        imagesavealpha($image_resized, true);
      }
    }

    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);

    if ( $delete_original ) {
      if ( $use_linux_commands )
        exec('rm '.$file);
      else
        @unlink($file);
    }

    switch ( strtolower($output) ) {
      case 'browser':
        $mime = image_type_to_mime_type($info[2]);
        header("Content-type: $mime");
        $output = NULL;
      break;
      case 'file':
        $output = $file;
      break;
      case 'return':
        return $image_resized;
      break;
      default:
      break;
    }

    switch ( $info[2] ) {
      case IMAGETYPE_GIF:
        imagegif($image_resized, $output);
      break;
      case IMAGETYPE_JPEG:
        imagejpeg($image_resized, $output);
      break;
      case IMAGETYPE_PNG:
        imagepng($image_resized, $output);
      break;
      default:
        return false;
    }

    return true;
  }



function upload_for_multiple($fileArray, $folder="", $types="",$index) {
//    echo $this->data[$model][$file_id]['name'];
//    exit;

   /* echo "<pre>";
    print_r($fileArray);
    echo $fileArray['name'][$index]; */


    if(!$fileArray['name'][$index]) return array('','No file specified');
    $file_title = $fileArray['name'][$index];

    //Get file extension

    $ext_arr = split("\.",basename($file_title));

    $ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension



    //Not really uniqe - but for all practical reasons, it is

    $uniqer = substr(md5(uniqid(rand(),1)),0,5);

    $file_name = $uniqer . '_' . $file_title;//Get Unique Name



    $all_types = explode(",",strtolower($types));

    if($types) {

        if(in_array($ext,$all_types));

        else {

            $result = "'".$fileArray['name'][$index]."' is not a valid file."; //Show error if any.

            return array('',$result);

        }

    }



    //Where the file must be uploaded to

    if($folder) $folder .= '/';//Add a '/' at the end of the folder

    $uploadfile = $folder . $file_name;
//    echo $uploadfile; exit;


    $result = '';

    //Move the file from the stored location to the new location
//    echo $uploadfile."<br />";
//    echo $fileArray['tmp_name'];
//    exit;
    if (!move_uploaded_file($fileArray['tmp_name'][$index], $uploadfile)) {

        $result = "Cannot upload the file '".$fileArray['name'][$index]."'"; //Show error if any.

        if(!file_exists($folder)) {

		echo $folder;
            $result .= " : Folder don't exist.";

        } elseif(!is_writable($folder)) {

            $result .= " : Folder not writable.";

        }
        elseif(!is_writable($uploadfile)) {

            $result .= " : File not writable.";

        }

        $file_name = '';



    } else {

        if(!$fileArray['size'][$index]) { //Check if the file is made

            @unlink($uploadfile);//Delete the Empty file

            $file_name = '';

            $result = "Empty file found - please use a valid file."; //Show the error message

        } else {

            chmod($uploadfile,0777);//Make it universally writable.

        }

    }

//	print_r(array($file_name,$result));
    return array($file_name,$result);

}


public function getExtension($str) {

        $i = strrpos($str, ".");

        if (!$i) {
            return "";
        }

        $l = strlen($str) - $i;

        $ext = substr($str, $i + 1, $l);

        return $ext;
    }


}
?>