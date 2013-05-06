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
    				<span class="text"><a href="<?php echo BASEURL;?>/dashboard/listing" title="Dashboard Listing">Dashboard</a></span>
    				<span class="arrow"></span>
    				<span class="text"><?php echo $dashboard->name . ' Listing';?></span>
    			</div>
    			<div class="search_box">
    				<form action="<?php echo BASEURL;?>/dashcategory/cat/search/<?php echo $dashboard->id; ?>" method="post" >
    					<fieldset>
    					<input type="hidden" name="dashboardId" value="<?php echo $dashboard->id; ?>"/>
    						<legend>Search Panel</legend>
    							<div class="tabular">
    								<span>Name: </span><input type="text" name="query" value="<?php if(isset($searchForm)) echo $searchForm['query'];?>"/><br>
    							</div>
    							<div class="tabular">
    								<span>Status: </span>
									<select name="status">
										<option <?php echo (isset($saveForm['status']) || @$status == "") ? 'selected=""' : ''; ?> value=""></option>
									    <option <?php echo (isset($saveForm['status']) || @$status == "1") ? 'selected="1"' : ''; ?> value="1">Enabled</option>
									    <option <?php echo (isset($saveForm['status']) || @$status == "0") ? 'selected="0"' : ''; ?> value="0">Disabled</option>
									</select>
									<br>
    							</div>
    							<div class="tabular">
    								<input type="submit" value="Search" name="searchForm" class="uiButton"><br>
    							</div>
    					</fieldset>
    				</form>
    			</div>
    			<div style="clear: both;"></div>
    			<div class="buttonStrip">
    				<a id="btnAdd" class="uiStripButton" href="<?php echo BASEURL;?>/dashcategory/cat/add/<?php echo $dashboard->id;?>" title="add Category">Add</a>
    				<a id="btnEdit" class="uiStripButton" href="<?php echo BASEURL;?>/dashcategory/cat/edit" title="edit Category">Edit</a>
					<a id="btnDelete" class="uiStripButton" href="<?php echo BASEURL;?>/dashcategory/cat/delete" title="delete Category">Delete</a>
					
					<div class="pagination">
						<span style="float: left;margin-right: 10px;"><?php echo $pgtotal;?></span>
						<a href="<?php echo BASEURL;?>/dashcategory/cat/pgprv/<?php echo $offset;?>" title="Previous Record"><span class="prv"></span></a>
						<a href="<?php echo BASEURL;?>/dashcategory/cat/pgnext/<?php echo $offset;?>" title="Next Record"><span class="nxt"></span></a>
					</div>
    			</div>
    			<div class="tablez">
    				<table class="recordTable">
    					<thead>
    						<tr>
    							<th></th>
    							<th>Name</th>
    							<th>Last Updated</th>
    							<th>Status</th>
    							<th>Options</th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php 
    							if($dashCategories):
    							foreach ($dashCategories as $dCat):
    						?>
    						<tr id="<?php echo $dCat->getId();?>" class="selectedRow">
    							<td><input name="selectedItem" type="checkbox" id="<?php echo $dCat->getId();?>" value="<?php echo $dashboard->id.':'.$dCat->getId();;?>"/> </td>
    							<td><?php echo $dCat->getName();?></td>
    							<td><?php echo $dCat->getDateupdated();?></td>
    							<td><?php echo ($dCat->getStatus() == 1)? '<span class=\'enabled\' title=\'enabled\'></span>' : '<span class=\'disabled\' title=\'disabled\'></span>';?></td>
    							<td><span class="viewicon"></span><a href="<?php echo BASEURL;?>/buddy/cat/listing/<?php echo $dCat->getId();?>">View Buddies</a></td>
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