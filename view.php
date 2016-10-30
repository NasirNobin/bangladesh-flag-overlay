<?php 
$id=@$_GET['id'];
$image=isset($_GET['image']) ? $_GET['image'] : "";

if(!empty($image)){
	$imgUrl="uploads/".$image;
	$save_name="supportBangladesh_".$image;
}else{
	$imgUrl="images/".$id.".jpg";
	$save_name="supportBangladesh_".$id;
}
if(!file_exists($imgUrl)){
	header("Location: index.php");
	exit();
}
$mtime=filemtime($imgUrl);
$urlWithVersion=$imgUrl.'?v='.$mtime;

require_once("header.php");
?>
<div class="container">
	<div class="heading"><h1>Support Bangladesh!</h1></div>
	<p>Download and use it as your profile picture. :)</p>
	<?php
	echo "<a class='btn btn-primary' href='{$urlWithVersion}' download='{$save_name}'>Download</a>";
	echo "<a class='btn btn-warning' href='index.php?again'>Generate another image</a><br/>";
	echo '<img src="'.$urlWithVersion.'" alt="" />';
	?>
	
	<div class="footer">Brought to you by <a href="http://trickbd.com/author/Nasir">TrickBD Team</a></div>
	<?php include('footer.php'); ?>
</div>
</body>
</html>