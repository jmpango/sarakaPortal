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
    				<span class="text">Search Tag Listing</span>
    			</div>
    			<div style="clear: both;"></div>
    			<div class="buttonStrip">
    				<a id="btnAdd" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/addSearchtag/<?php echo  $buddy->getId();?>" title="add search tag">Add</a>
    				<a id="btnEdit" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/editSearchtag" title="edit search tag">Edit</a>
					<a id="btnDelete" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/deleteSearchtag" title="delete search tag">Delete</a>
					
					<div class="pagination">
						<span style="float: left;margin-right: 10px;"><?php echo $pgtotal;?></span>
					</div>
    			</div>
    			<div class="tablez">
    				<table class="recordTable">
    					<thead>
    						<tr>
    							<th></th>
    							<th>Search Value</th>
    							<th>Date Last Updated</th>
    							<th>Status</th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php 
    							if($searchtags):
    							foreach ($searchtags as $searchtag):
    						?>
    						<tr id="<?php echo $searchtag->getId();?>" class="selectedRow">
    							<td><input name="selectedItem" type="checkbox" id="<?php echo $searchtag->getId();?>" value="<?php echo $searchtag->getId().':'.$buddy->getId();?>"/> </td>
    							<td><?php echo $searchtag->getSearchValue();?></td>
    							<td><?php echo $searchtag->getDateupdated();?></td>
    							<td><?php echo ($searchtag->getStatus() == 1)? '<span class=\'enabled\' title=\'enabled\'></span>' : '<span class=\'disabled\' title=\'disabled\'></span>';?></td>
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