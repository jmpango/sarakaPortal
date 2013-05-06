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
    				<span class="text"><a href="<?php echo BASEURL;?>/dashcategory/cat/index/<?php echo $buddy->getDashboardCategory()->getDashboard()->getId();?>" title="back to <?php echo $buddy->getDashboardCategory()->name;?> Listing"><?php echo $buddy->getDashboardCategory()->name;?></a></span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL;?>/buddy/cat/listing/<?php echo $buddy->getDashboardCategory()->getId();?>"><?php echo $buddy->name;?></a></span>
    				<span class="arrow"></span>
    				<span class="text">Location Listing</span>
    			</div>
    			<div style="clear: both;"></div>
    			<div class="buttonStrip">
    				<a id="btnAdd" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/addLocation/<?php echo  $buddy->getId();?>" title="add location">Add</a>
    				<a id="btnEdit" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/editLocation" title="edit location">Edit</a>
					<a id="btnDelete" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/deleteLocation" title="delete location">Delete</a>
					
					<div class="pagination">
						<span style="float: left;margin-right: 10px;"><?php echo $pgtotal;?></span>
					</div>
    			</div>
    			<div class="tablez">
    				<table class="recordTable">
    					<thead>
    						<tr>
    							<th></th>
    							<th>Name</th>
    							<th>Date Last Updated</th>
    							<th>Status</th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php 
    							if($locations):
    							foreach ($locations as $location):
    						?>
    						<tr id="<?php echo $location->getId();?>" class="selectedRow">
    							<td><input name="selectedItem" type="checkbox" id="<?php echo $location->getId();?>" value="<?php echo $location->getId().':'.$buddy->getId();?>"/> </td>
    							<td><?php echo $location->getLocationName();?></td>
    							<td><?php echo $location->getDateupdated();?></td>
    							<td><?php echo ($location->getStatus() == 1)? '<span class=\'enabled\' title=\'enabled\'></span>' : '<span class=\'disabled\' title=\'disabled\'></span>';?></td>
    						</tr>
    						<?php 
    							endforeach;
    							endif;
    						?>
    					</tbody>
    				</table>
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