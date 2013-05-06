<?php 
include_once HOME . DS . 'model' . DS . 'user.php';
include_once HOME . DS . 'model' . DS . 'dashboard.php';
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
    				<span class="text"><a href="<?php echo BASEURL;?>" title="back to home">Home</a></span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL;?>/dashboard/listing" title="back to dashboard">Dashboard</a></span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL;?>/dashcategory/cat/index/<?php echo $buddy->getDashboardCategory()->getId();?>" title="back to <?php echo $buddy->getDashboardCategory()->name;?> Listing"><?php echo $buddy->getDashboardCategory()->name;?></a></span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL;?>/buddy/cat/listing/<?php echo $buddy->getDashboardCategory()->getId();?>"><?php echo $buddy->name;?></a></span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL;?>/buddy/cat/image/<?php echo $buddy->getId();?>">Picture Listing</a></span>
    				<span class="arrow"></span>
    				<span class="text">Add <?php echo $buddy->name;?> Picture </span>
    			</div>
    			<div style="clear: both;"></div>
					<div class="formTable">
    				<form action="<?php echo BASEURL;?>/buddy/cat/saveImage/<?php echo $buddy->getId();?>" method="post" enctype="multipart/form-data" >
    							<p>
    								<input type="hidden" name="editImageName" value="<?php echo $editImageName;?>"/>
    								<input type="hidden" name="id" value="<?php if(isset($saveForm)) echo $saveForm['id'];else echo @$id; ?>"/>
    								<input type="hidden" name="name" value="<?php if(isset($saveForm)) echo $saveForm['name']; else echo preg_replace('/\s+/', '', strtolower($buddy->name));?>"/>
    								<span style="font-weight: bold;">Image Name: <?php if(isset($saveForm)) echo $saveForm['name']; else echo preg_replace('/\s+/', '', strtolower($buddy->name));?></span>
    							</p>
    							<p></p>
    							<p>
    								<span>Picture: </span>
    								 <input name="pic_file" type="file" />
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