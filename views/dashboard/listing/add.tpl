<?php 
include_once HOME . DS . 'model' . DS . 'user.php';
include_once HOME . DS . 'views' . DS . 'header.php';
?>
    <div class="main-wrapper">
    	<div class="panel">
    		<div class="menu_dv layout">
    			<div class="menu"><a href="<?php echo  BASEURL;?>" title="Home">Home</a></div>
    			<div class="menu"><a href="<?php echo  BASEURL . DS . 'dashboard' .DS . 'listing';?>" title="Dashboard Listing">Dashboard</a></div>
    			<div class="menu"><a href="<?php echo  BASEURL;?>" title="Control Panel">C panel</a></div>
    		</div>
    		<div class="content layout">
    			<div class="breadcrumb">
    				<span class="text">Home</span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL;?>/dashboard/listing" title="Back to listing">Dashboard</a></span>
    				<span class="arrow"></span>
    				<span class="text">Add</span>
    			</div>
    			<div style="clear: both;"></div>
    			<div class="formTable">
    				<form action="<?php echo BASEURL;?>/dashboard/listing/save" method="post" >
    							<p>
    								<input type="hidden" name="pageName" value="<?php echo 'dashboard'.DS.'listing'.DS.'add';?>"/>
    								<input type="hidden" name="id" value="<?php if(isset($saveForm)) echo $saveForm['id'];else echo @$id; ?>"/>
    								<span style="margin-right: 5px;">Name: </span>
    								<input type="text" name="name" value="<?php if(isset($saveForm)) echo $saveForm['name'];else echo @$name;?>"><br>
    							</p>
    							<p>
    								<span>Tagline: </span>
    								<input type="text" name="tagline" value="<?php if(isset($saveForm)) echo $saveForm['tagline'];else echo @$tagline;?>"><br>
    							</p>
    							<p>
    								<span style="margin-right: 10px;">Status: </span>
    								<select name="status">
									    <option <?php echo (isset($saveForm['status']) || @$status == "1") ? 'selected="1"' : ''; ?> value="1">Enabled</option>
									    <option <?php echo (isset($saveForm['status']) || @$status == "0") ? 'selected="0"' : ''; ?> value="0">Disabled</option>
									</select>
    							</p>
    							<p>
    								<input type="submit" value="Save" name="saveForm" class="uiStripButton"><br>
    							</p>
    				</form>
    				</div>
    		</div>
    	</div>
    	<?php include_once HOME.DS.'views'.DS.'footer.php';?>
    </div>