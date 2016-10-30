<?php 

if(!defined('ABSPATH')){ header("Location: index.php"); exit(); }

function edit($url,$fbid=false){
   $im = imagecreatefromfile($url);
   if($im){
	    $ix = imagesx($im);
	    $iy = imagesy($im);
	    $r=($ix+$iy)/3;
		
	    $ra=70;
		$ga=70;

	    $red= imagecolorallocatealpha($im,244,42,65,$ra);
	    $green= imagecolorallocatealpha($im,0,106, 78,$ga);
		
	    imagefilledrectangle($im, 0,0, $ix, $iy, $green);
	    imagefilledellipse($im, $ix/2, $iy/2,$r, $r, $red);
		
		imagefilter($im, IMG_FILTER_BRIGHTNESS, 10);
		imagefilter($im, IMG_FILTER_CONTRAST, -15);
		
		if($fbid){
			$save=imageSave($im, "images/".$fbid.".jpg");
		}
		else{
			$save=imageSave($im, $url);
		}
	    
	    if($save){
	        return imagedestroy($im);
	    } 
    }
}
function imageSave($image,$save_path){
	switch(get_file_ext($save_path)) {
			case 'jpeg':
			case 'jpg': return imagejpeg($image,$save_path); break;
			case 'png': return imagepng($image,$save_path); break;		
			default: return false; break;
	}
}
function imagecreatefromfile($file){
	switch (get_file_ext($file)) {
		case 'jpeg':
		case 'jpg': return imagecreatefromjpeg($file); break;
		case 'png': return imagecreatefrompng($file); break; 
		default: return false; break;
	}
}
function get_file_ext($url){
	// if facebook link, then return jpg
	$ext=strtolower(pathinfo($url, PATHINFO_EXTENSION));
	if($ext){
		return $ext;
	}else{
		if(strpos($url,"graph.facebook.com")){
			return "jpg";
		}
	}
}

function send_to_header($fbid,$name,$token){
	$txt=<<<EOT
<script type="text/javascript">
	var fbid={$fbid};
	var user_name='{$name}';
</script>
	
EOT;

return $txt;
}
