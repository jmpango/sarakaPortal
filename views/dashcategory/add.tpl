<?php 
include_once HOME . DS . 'views' . DS . 'header.php';
if(isset($_SESSION['user'])){
?>
    <div class="main-wrapper">
    	<div class="panel">
    		<?php include_once HOME.DS.'views'.DS.'menu.php';?>
    		<div class="content layout">
    			<div class="breadcrumb">
    				<span class="text"><a href="<?php echo BASEURL;?>" title="Back to home">Home</a></span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL;?>/dashboard/listing" title="Back to listing">Dashboard</a></span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL;?>/dashcategory/cat/index/<?php echo $dashboard->id;?>" title="Back to <?php echo $dashboard->name;?> listing"><?php echo $dashboard->name;?></a></span>
    				<span class="arrow"></span>
    				<span class="text">add</span>
    			</div>
    			<div style="clear: both;"></div>
    			<div class="formTable">
    				<form action="<?php echo BASEURL;?>/dashcategory/cat/save/<?php echo $dashboard->id;?>" method="post" >
    							<p>
    								<input type="hidden" name="pageName" value="<?php echo 'dashcategory'.DS.'cat'.DS.'add'.DS. $dashboard->id;?>"/>
    								<input type="hidden" name="id" value="<?php if(isset($saveForm)) echo $saveForm['id'];else echo @$id; ?>"/>
    								<span>Name: </span>
    								<input type="text" name="name" value="<?php if(isset($saveForm)) echo $saveForm['name'];else echo @$name;?>"><br>
    							</p>
    							<p>
    								<span>Status: </span>
    								<select name="status">
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