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
    				<span class="text"><a href="<?php echo BASEURL . DS . 'cpanel' . DS . 'vseeding';?>" title="back to seeding listing">Seeding(s)</a></span>
    				<span class="arrow"></span>
    				<span class="text">add</span>
    			</div>
    			<div style="clear: both;"></div>
    			<div class="formTable">
    				<form action="<?php echo BASEURL . DS . 'cpanel' . DS . 'saveseeding';?>" method="post" >
    							<p>
    								<input type="hidden" name="id" value="<?php if(isset($saveForm)) echo $saveForm['id'];else echo @$id; ?>"/>
    								<span>Name: </span>
    								<input  style="margin-left: 69px;" type="text" name="name" value="<?php if(isset($saveForm)) echo $saveForm['name'];else echo @$name;?>"><br>
    							</p>
    							<p>
    								<span>Description: </span>
    								<textarea  style="margin-left: 38px;" rows="5" cols="48" name="description" ><?php if(isset($saveForm)) echo $saveForm['description'];else echo @$description;?></textarea>
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