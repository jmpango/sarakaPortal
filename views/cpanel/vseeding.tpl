<?php 
include_once HOME . DS . 'views' . DS . 'header.php';
if(isset($_SESSION['user'])){
?>
<div class="main-wrapper">
    	<div class="panel">
    		<?php include_once HOME.DS.'views'.DS.'menu.php';?>
    		<div class="content layout">
    			<div class="breadcrumb">
    				<span class="text"><a href="<?php echo BASEURL . DS . 'dashboard'. DS . 'index';?>" title="back to home">Home</a></span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL . DS . 'cpanel' . DS . 'index';?>" title="back to cpanel">C Panel</a></span>
    				<span class="arrow"></span>
    				<span class="text">Seeding Listing</span>
    			</div>
    			<div style="clear: both;"></div>
    			<div class="buttonStrip">
    				<a id="btnAdd" class="uiStripButton" href="<?php echo BASEURL . DS . 'cpanel' . DS . 'addseeding';?>" title="add Seeding">Add</a>
    				<a id="btnEdit" class="uiStripButton" href="<?php echo BASEURL . DS . 'cpanel' .DS. 'cat' . DS . 'editseeding';?>" title="edit Seeding">Edit</a>
					<a id="btnDelete" class="uiStripButton" href="<?php echo BASEURL . DS . 'cpanel' . DS . 'cat' . DS . 'deleteseeding';?>" title="delete Seeding">Delete</a>
					
					<div class="pagination">
						<span style="float: left;margin-right: 10px;"><?php echo $pgtotal;?></span>
						<a href="<?php echo BASEURL;?>/cpanel/cat/seedingpgprv/<?php echo $offset;?>" title="Previous Record"><span class="prv"></span></a>
						<a href="<?php echo BASEURL;?>/cpanel/cat/seedingpgnext/<?php echo $offset;?>" title="Next Record"><span class="nxt"></span></a>
					</div>
    			</div>
    			<div class="tablez">
    				<table class="recordTable">
    					<thead>
    						<tr>
    							<th></th>
    							<th>Name</th>
    							<th>Description</th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php 
    							if($seedings):
    							foreach ($seedings as $seed):
    						?>
    						<tr id="<?php echo $seed->getId();?>" class="selectedRow">
    							<td><input name="selectedItem" type="checkbox" id="<?php echo $seed->getId();?>" value="<?php echo $seed->getId();?>"/> </td>
    							<td><?php echo $seed->getName();?></td>
    							<td><?php echo $seed->getDescription();?></td>
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