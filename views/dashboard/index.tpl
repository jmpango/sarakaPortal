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
    				<span class="text"><a href="<?php echo  BASEURL;?>">Home</a></span>
    				<span class="arrow"></span>
    				<span class="text">Buddy Listings</span>
    			</div>
    			<div class="search_box">
    				<form action="<?php echo BASEURL;?>/dashboard/buddysearch" method="post" >
    					<?php include_once HOME.DS.'views'.DS.'searchfields.php';?>
    				</form>
    			</div>
    			<div class="pagination">
						<span style="float: left;margin-right: 10px;"><?php echo $pgtotal;?></span>
						<?php if(!empty($offset)){?>
							<a href="<?php echo BASEURL;?>/dashboard/listing/buddypgprv/<?php echo $offset?>" title="Previous Record"><span class="prv"></span></a>
							<a href="<?php echo BASEURL;?>/dashboard/listing/buddypgnext/<?php echo $offset?>" title="Next Record"><span class="nxt"></span></a>
						<?php }?>
					</div>
    			<div class="tablez">
    				<table class="recordTable">
    					<thead>
    						<tr>
    							<th>Name</th>
    							<th>Contact</th>
    							<th>Address</th>
    							<th>Status</th>
    							<th>Owner</th>
    							<th></th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php 
    							if($buddies):
    							foreach ($buddies as $buddy):
    						?>
	    						<tr id="<?php echo $buddy->getId();?>" class="selectedRow">
	    							<td>
	    								<p><?php echo $buddy->getName();?> <span style="color: rgb(241, 64, 64); font-size: 10px;">(<?php echo $buddy->getDateupdated();?>)</span></p>
	    								<p><?php echo $buddy->getTagline();?></p>	
	    							</td>
	    							<td>
	    								<p><?php echo $buddy->getTelphoneNos();?> | <span style="color: green;">Fax: <?php echo $buddy->getFax();?></span></p>
	    								<p><?php echo $buddy->getUrl();?></p>
	    							</td>
	    							<td>
	    								<p><?php echo $buddy->getAddress();?></p>
	    								<p><?php echo $buddy->getEmail();?></p>
	    							</td>
	    							<td><?php echo ($buddy->getStatus() == 1)? '<span class=\'enabled\' title=\'enabled\'></span>' : '<span class=\'disabled\' title=\'disabled\'></span>';?></td>
	    							<td><span style="color: rgb(34, 26, 238);"><?php echo $buddy->getDashboardCategory()->getName();?></span></td>
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