<?php 
include_once HOME . DS . 'model' . DS . 'user.php';
include_once HOME . DS . 'model' . DS . 'dashboard.php';
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
    				<span class="text"><a href="<?php echo BASEURL;?>/dashcategory/cat/index/<?php echo $dashcategory->getDashboard()->getId();?>" title="Back to <?php echo $dashcategory->getDashboard()->name;?> listing"><?php echo $dashcategory->getDashboard()->name;?></a></span>
    				<span class="arrow"></span>
    				<span class="text"><a href="<?php echo BASEURL;?>/buddy/cat/listing/<?php echo $dashcategory->getId();?>" title="Back to <?php echo $dashcategory->name;?> listing"><?php echo $dashcategory->name;?></a></span>
    				<span class="arrow"></span>
    				<span class="text">add</span>
    			</div>
    			<div style="clear: both;"></div>
					<div class="formTable">
    				<form action="<?php echo BASEURL;?>/buddy/cat/save/<?php echo $dashcategory->getId();?>" method="post" >
    							<p>
    								<input type="hidden" name="pageName" value="<?php echo 'dashcategory'.DS.'cat'.DS.'add'.DS. $dashcategory->id;?>"/>
    								<input type="hidden" name="id" value="<?php if(isset($saveForm)) echo $saveForm['id'];else echo @$id; ?>"/>
    								<span>Name: </span><span style="color: red;">*</span>
    								<input style="margin-left: 40px;"  type="text" name="name" value="<?php if(isset($saveForm)) echo $saveForm['name'];else echo @$name;?>"><br>
    							</p>
    							<p>
    								<span>Tagline: </span>
    								<input style="margin-left: 45px;"  type="text" name="tagline" value="<?php if(isset($saveForm)) echo $saveForm['tagline'];else echo @$tagline;?>"><br>
    							</p>
    							<p>
    								<span>Address: </span>
    								<textarea  style="margin-left: 38px;" rows="5" cols="48" name="address" ><?php if(isset($saveForm)) echo $saveForm['address'];else echo @$address;?></textarea>
    							</p>
    							<p>
    								<span>Telphone 1: </span><span style="color: red; margin-right: 10px;">*</span>
    								<span style="display: inline; font-weight: bold;">
    									+2560
    								<input style="margin-left: 5px;width: 350px;" type="text" name="telphone1" value ="<?php if(isset($saveForm)) echo $saveForm['telphone1'];else echo @$telphone1;?>"/><br>
    								</span>
    							</p>
    							<p>
    								<span style="margin-right: 20px;">Telphone 2: </span>
    								<span style="display: inline; font-weight: bold;">
    									+2560
    								<input style="margin-left: 5px; width: 350px;" type="text" name="telphone2" value ="<?php if(isset($saveForm)) echo $saveForm['telphone2'];else echo @$telphone2;?>"/><br>
    								</span>
    							</p>
    							<p>
    								<span style="margin-right: 20px;">Telphone 3: </span>
    								<span style="display: inline; font-weight: bold;">
    									+2560
    									<input type="text" style="width: 350px;" name="telphone3" value ="<?php if(isset($saveForm)) echo $saveForm['telphone3'];else echo @$telphone3;?>"/><br>
    								</span>
    							</p>
    							<p>
    								<span>Email: </span>
    								<input style="margin-left: 55px;" type="text" name="email" value="<?php if(isset($saveForm)) echo $saveForm['email'];else echo @$email;?>"><br>
    							</p>
    							<p>
    								<span>Fax: </span>
    								<input style="margin-left: 66px;" type="text" name="fax" value="<?php if(isset($saveForm)) echo $saveForm['fax'];else echo @$fax;?>"><br>
    							</p>
    							<p>
    								<span>Url: </span>
    								<input style="margin-left: 70px;" type="text" name="url" value="<?php if(isset($saveForm)) echo $saveForm['url'];else echo @$url;?>"><br>
    							</p>
    							<p>
    								<span>Status: </span>
    								<select style="margin-left: 48px;" name="status">
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