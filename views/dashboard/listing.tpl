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
    				<span class="text">Dashboard</span>
    				<span class="arrow"></span>
    				<span class="text">Listing</span>
    			</div>
    			<div class="search_box">
    				<form action="<?php echo BASEURL;?>/dashboard/listing/search" method="post" >
    					<fieldset>
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
    				<a id="btnAdd" class="uiStripButton" href="<?php echo BASEURL;?>/dashboard/listing/add" title="add listing">Add</a>
    				<a id="btnEdit" class="uiStripButton" href="<?php echo BASEURL;?>/dashboard/listing/edit" title="edit listing">Edit</a>
					<a id="btnDelete" class="uiStripButton" href="<?php echo BASEURL;?>/dashboard/listing/delete" title="delete listing">Delete</a>
					
					<div class="pagination">
						<span style="float: left;margin-right: 10px;"><?php echo $pgtotal;?></span>
						<a href="<?php echo BASEURL;?>/dashboard/listing/pgprv/<?php echo $offset?>" title="Previous Record"><span class="prv"></span></a>
						<a href="<?php echo BASEURL;?>/dashboard/listing/pgnext/<?php echo $offset?>" title="Next Record"><span class="nxt"></span></a>
					</div>
    			</div>
    			<div class="tablez">
    				<table class="recordTable">
    					<thead>
    						<tr>
    							<th></th>
    							<th>Name</th>
    							<th>Tagline</th>
    							<th>Last Updated</th>
    							<th>Status</th>
    							<th>Options</th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php 
    							if($dashboards):
    							foreach ($dashboards as $dboard):
    						?>
    						<tr id="<?php echo $dboard->getId();?>" class="selectedRow">
    							<td><input name="selectedItem" type="checkbox" id="<?php echo $dboard->getId();?>" value="<?php echo $dboard->getId();?>"/> </td>
    							<td><?php echo $dboard->getName();?></td>
    							<td><?php echo $dboard->getTagline();?></td>
    							<td><?php echo $dboard->getDateupdated();?></td>
    							<td><?php echo ($dboard->getStatus() == 1)? '<span class=\'enabled\' title=\'enabled\'></span>' : '<span class=\'disabled\' title=\'disabled\'></span>';?></td>
    							<td><span class="viewicon"></span><a href="<?php echo BASEURL;?>/dashcategory/cat/index/<?php echo $dboard->getId();?>">View Categories</a></td>
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