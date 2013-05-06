<?php 
include_once HOME . DS . 'model' . DS . 'user.php';
include_once HOME . DS . 'model' . DS . 'buddy.php';
include_once HOME . DS . 'model' . DS . 'buddyrating.php';
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
    				<span class="text"><a href="<?php echo BASEURL;?>/dashcategory/cat/index/<?php echo $buddy->getDashboardCategory()->getDashboard()->getId();?>" title="back to <?php echo $buddy->getDashboardCategory()->name;?> Listing"><?php echo $buddy->getDashboardCategory()->name;?></a></span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL;?>/buddy/cat/listing/<?php echo $buddy->getDashboardCategory()->getId();?>"><?php echo $buddy->name;?></a></span>
    				<span class="arrow"></span>
    				<span class="text"><?php echo $buddy->name.'\'s';?> Image Listing</span>
    			</div>
    			<div style="clear: both;"></div>
    			<div class="buttonStrip">
    			<?php if($imageurl == ""){ ?>
    				<a id="btnAdd" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/addImage/<?php echo  $buddy->getId();?>" title="add Image">Add</a>
    			<?php }?>
    				<a id="btnEdit" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/editImage" title="edit Image">Edit</a>
					<a id="btnDelete" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/deleteImage/<?php echo  $buddy->getId();?>" title="delete Image">Delete</a>
					
					<div class="pagination">
						<span style="float: left;margin-right: 10px;"><?php echo $pgtotal;?></span>
					</div>
    			</div>
    			<div class="tablez">
    				<table class="recordTable">
    					<thead>
    						<tr>
    							<th></th>
    							<th>Name: <?php if($imageurl != ""){ echo $imageName; }?></th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php if($imageurl != ""){?>
    						<tr id="<?php echo $imageName;?>" class="selectedRow">
    							<td style="border-bottom: none; vertical-align: top;"><input name="selectedItem" type="checkbox" id="<?php echo $imageName;?>" value="<?php echo $imageName.":".$buddy->getId();?>"/> </td>
    							<td style="float: left; border-bottom: none; width: 90%;"><img src="<?php echo $imageurl;?>" /></td>
    						</tr>
    						<tr class="selectedRow">
    							<td style="border-bottom: none; vertical-align: top;">[S]</td>
    							<td style="float: left; border-bottom: none; width: 90%;"><img src="<?php echo BASEURL . '/buddy/listing/smallImage/' . $imageName;?>" /></td>
    						</tr>
    						<?php }?>
    					</tbody>
    				</table>
    			</div>
    		</div>
    	</div>
    	<?php include_once HOME.DS.'views'.DS.'footer.php';?>
    </div>