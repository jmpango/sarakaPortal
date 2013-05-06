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
    				<span class="text"><a href="<?php echo BASEURL;?>/dashcategory/cat/index/<?php echo $dashcategory->getDashboard()->getId();?>" title="back to <?php echo $dashcategory->name;?> Listing"><?php echo $dashcategory->name;?></a></span>
    				<span class="arrow"></span>
    				<span class="text">Buddy Listing</span>
    			</div>
    			<div class="search_box">
    				<form action="" method="post" >
						<fieldset>
							<legend>Search Panel</legend>
							<div class="tabular">
								<span>Buddy Name: </span><input name="name"  type="text"><br>
							</div>
							<div class="tabular">
								<span>Status: </span>
								<select name="status">
									<option <?php echo (isset($saveForm['status']) || @$status == "") ? 'selected=""' : ''; ?> value=""></option>
									<option <?php echo (isset($saveForm['status']) || @$status == "1") ? 'selected="1"' : ''; ?> value="1">Enabled</option>
									<option <?php echo (isset($saveForm['status']) || @$status == "0") ? 'selected="0"' : ''; ?> value="0">Disabled</option>
								</select>
							</div>
							<div class="tabular">
								<input type="submit" value="Search" name="searchBtn" class="uiButton"><br>
							</div>
						</fieldset>
    				</form>
    			</div>
    			<div style="clear: both;"></div>
    			<div class="buttonStrip">
    				<a id="btnAdd" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/add/<?php echo $dashcategory->getId();?>" title="add buddy">Add</a>
    				<a id="btnEdit" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/edit" title="edit buddy">Edit</a>
					<a id="btnDelete" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/delete" title="delete buddy">Delete</a>
					<a id="btnDetailed" class="uiStripButton" href="<?php echo BASEURL;?>/buddy/listing/details" title="View buddy Details">View Deatails</a>
					
					<div class="pagination">
						<span style="float: left;margin-right: 10px;"><?php echo $pgtotal;?></span>
						<a href="<?php echo BASEURL;?>/buddy/listing/pgprv/<?php echo $offset?>" title="Previous Record"><span class="prv"></span></a>
						<a href="<?php echo BASEURL;?>/buddy/listing/pgnext/<?php echo $offset?>" title="Next Record"><span class="nxt"></span></a>
					</div>
    			</div>
    			<div class="tablez">
    				<table class="recordTable">
    					<thead>
    						<tr>
    							<th></th>
    							<th>Name</th>
    							<th>TagLine</th>
    							<th>Address</th>
    							<th>Telphone Nos</th>
    							<th>Last Updated</th>
    							<th>Status</th>
    							<th></th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php 
    							if($buddies):
    							foreach ($buddies as $buddy):
    						?>
    						<tr id="<?php echo $buddy->getId();?>" class="selectedRow">
    							<td><input name="selectedItem" type="checkbox" id="<?php echo $buddy->getId();?>" value="<?php echo $buddy->getId().':'.$dashcategory->getId();?>"/> </td>
    							<td><?php echo $buddy->getName();?></td>
    							<td><?php echo $buddy->getTagline();?></td>
    							<td><?php echo $buddy->getAddress();?></td>
    							<td><?php echo $buddy->getTelphoneNos();?></td>
    							<td><?php echo $buddy->getDateupdated();?></td>
    							<td><?php echo ($buddy->getStatus() == 1)? '<span class=\'enabled\' title=\'enabled\'></span>' : '<span class=\'disabled\' title=\'disabled\'></span>';?></td>
    							<td>
    								<span id="<?php echo $buddy->getId();?>" class="more">[View..]</span>
    								<div id="more_dv_<?php echo $buddy->getId();?>" style="z-index: 10; position: absolute; visibility: hidden; border: 1px solid rgb(204, 204, 204); padding: 5px;background: rgb(247, 247, 247);">
    									<p style="margin-bottom: 5px;">
    										<a href="<?php echo BASEURL;?>/buddy/cat/location/<?php echo $buddy->getId();?>" title="view Buddy locations">Locations</a>
    									</p>
    									<p style="margin-bottom: 5px;">
    										<a href="<?php echo BASEURL;?>/buddy/cat/searchtag/<?php echo $buddy->getId();?>" title="view Buddy search tags">Search Tags</a>
    									</p>
    									<p style="margin-bottom: 5px;">
    										<a href="<?php echo BASEURL;?>/buddy/cat/image/<?php echo $buddy->getId();?>" title="view Buddy Pictures">Images</a>
    									</p>
    									<p style="margin-bottom: 5px;">
    										<a href="" title="view Buddy comments">Comments</a>
    									</p>
    									<p style="margin-bottom: 5px;">
    										<a href="" title="view Buddy Mobile Usage">Usage</a>
    									</p>
    								</div>		
    							</td>
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