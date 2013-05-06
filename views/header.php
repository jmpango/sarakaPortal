<?php 
if (session_id() == ''){
	session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Saraka Web Portal</title>
		<link rel="stylesheet" type="text/css" href="<?php echo BASEURL . DS . 'utilities' . DS . 'css' . DS . 'system.css';?>" />
		<script type="text/javascript" src="<?php echo BASEURL . DS . 'utilities' .DS .'js'.DS.'jquery-1.6.2.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo BASEURL . DS . 'utilities' .DS .'js'.DS.'jquery-ui-1.8.15.custom.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo BASEURL . DS . 'utilities' .DS .'js'.DS.'jquery.getUrlParam.js';?>"></script>
		<script type="text/javascript" src="<?php echo BASEURL . DS . 'utilities' .DS .'js'.DS.'system.js';?>"></script>
	</head>
	<body>
		<div class="header layout">
			<div class="logo">Saraka Web Portal</div>
			<?php if(isset($error_message)){?>
			<div class="messagebox error_box"><span class="icon error_ico"></span><span style="float: left; padding-top: 5px;"><?php echo $error_message;?></span></div>
			<?php } else if(isset($info_message)){ ?>
			<div class="messagebox info_box"><span class="icon info_ico"></span><span style="float: left; padding-top: 5px;"><?php echo $info_message;?></span></div><?php }?>
			<?php if(isset($_SESSION['user'])){?>
			<div class="sbcredentials">
						<div class="wtext">Welcome: <?php echo $_SESSION['user']->getFullNames();?> </div>
						<div class="lgout"><a href="<?php echo BASEURL?>/login/logout" title="logout">Logout</a></div>
					<div style="clear: both;"></div>
			</div><?php }?>
		</div>
	</body>
</html>