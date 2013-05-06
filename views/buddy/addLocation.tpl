<?php 
include_once HOME . DS . 'views' . DS . 'header.php';
if(isset($_SESSION['user'])){
?>
    <div class="main-wrapper">
    	<div class="panel">
    		<?php include_once HOME.DS.'views'.DS.'menu.php';?>
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
    				<span class="text"><a href="<?php echo BASEURL;?>/buddy/cat/location/<?php echo $buddy->getId();?>">Location Listing</a></span>
    				<span class="arrow"></span>
    				<span class="text">Add  </span>
    			</div>
    			<div style="clear: both;"></div>
					<div class="formTable">
    				<form action="<?php echo BASEURL;?>/buddy/cat/saveLocation/<?php echo $buddy->getId();?>" method="post" >
    							<p>
    								<input type="hidden" name="pageName" value="<?php echo 'buddy'.DS.'cat'.DS.'listing'.DS. $buddy->getDashboardCategory()->id;?>"/>
    								<input type="hidden" name="id" value="<?php if(isset($saveForm)) echo $saveForm['id'];else echo @$id; ?>"/>
    								<span>Location Name: </span>
    								<input style="margin-left: 50px;"  type="text" name="name" value="<?php if(isset($saveForm)) echo $saveForm['name'];else echo @$name;?>"><br>
    							</p>
    							<p>
    								<span>Status: </span>
    								<select style="margin-left: 105px;" name="status">
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
     <?php 
		}else{
			header('Location: '.BASEURL.'/login/index');
		}
    ?>