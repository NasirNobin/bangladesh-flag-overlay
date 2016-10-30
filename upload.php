<?php 
if(!defined('ABSPATH')){ header("Location: index.php"); exit(); }

require_once("functions.php");
require_once("auth2.php"); 

if(isset($_FILES['image'])){
    $name=$_FILES['image']['name'];
	$time=time();
	$image_name=$time."_".$name;
    $save_url="uploads/".$image_name;
    $filetype= get_file_ext($save_url); 

    if($filetype== "jpeg" || $filetype == "jpg" || $filetype == "png"){
    	$check = getimagesize($_FILES["image"]["tmp_name"]); 
    	if($check){
  			move_uploaded_file($_FILES['image']['tmp_name'], $save_url);
		    if(edit($save_url)){
				header("Location: view.php?image=".$image_name);
		    }
		    else{
		    	$txt="Failed to edit";
		   	}
    	}else{
    		$txt="File is not an image";
    	}
    }else{
    	$txt="File format jpeg,jpg,png allowed";
    }
}

require_once("header.php");
?>
<div class="container">
	<div class="heading"><h1>Support Bangladesh!</h1></div>
	<p>Bangladeshi flag with your picture!</p>
	<?php echo isset($txt) ? "<p>".$txt."</p>" : ""; ?>
	<div id="status" class='welcome'>
		<?php 
		if(isset($script)){
		?>
			<div>
				<img src="https://graph.facebook.com/<?php echo $user_id; ?>/picture" />
				<p>Hi, <?php echo $user_name; ?></p>
				<div>
					<a class="btn btn-primary" href="http://trickbd.com/app/supportBangladesh/?access_token=<?php echo $longLivedAccessToken; ?>&generate_now=true">Use Facebook profile picture</a>
				</div>
			</div>
		<?php 
		}else{
		?>
		
		<a class="btn btn-primary" href="<?php echo $authUrl ?>">Use Facebook profile picture</a>
		<div class="note">
			<p><small>* Allow app to get your facebook profile picture.</small></p>
		</div>
		<?php } ?>
	</div>
	<div class="upload_form">
		<p>or, Upload a new picture</p>
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="file" name="image"/>
			<input type="submit" class="btn btn-primary" value="Upload"/>
		</form>
	</div>
	<div class="footer">Brought to you by <a href="http://trickbd.com/author/Nasir">TrickBD Team</a></div>
</div>
<script type="text/javascript" src="script2.js?v=<?php echo filemtime("script2.js"); ?>"></script>
<?php include('footer.php'); ?>
</body>
</html>