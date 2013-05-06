<?php
include_once HOME . DS . 'views' . DS . 'header.php';
if(isset($_SESSION['user'])){
?>
 <div class="main-wrapper">
    	<div class="panel">
    		<?php include_once HOME.DS.'views'.DS.'menu.php';?>
    		<div class="content layout">
    			<div class="breadcrumb">
    				<span class="text"><a href="<?php echo BASEURL . DS . 'dashboard' .DS .'index'?>" title="back to home">Home</a></span>
    				<span class="arrow"></span>
    				<span class="text">Control Panel</span>
    				<span class="arrow"></span>
    			</div>
    		<div style="clear: both;"></div>
    		<div class="cpanel">
    			<div class="cpanel_row">
    				<div class="cpanel_item">
    					<a title="Adminster Users" href="">
							<span class="user_icon"></span>
							<span id="text">Manage Users</span>
						</a>
    				</div>
    				<div class="cpanel_item">
    					<a title="Manage Seedings" href="<?php echo BASEURL . DS . 'cpanel' .DS .'vseeding'?>">
							<span class="seeding_icon"></span>
							<span id="text">Seedings</span>
						</a>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<?php
}else{
	header('Location: '.BASEURL.'/login/index');
}
?>