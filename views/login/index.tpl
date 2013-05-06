<?php 
include_once HOME . DS . 'views' . DS . 'header.php';
if(isset($_SESSION['user'])){
	header('Location: '.BASEURL.'/login/index');
}else{
?>
	<div class="main-wrapper">
		<div class="login-wrapper layout">
			<form action="<?php echo BASEURL;?>/login/validate" method="post">
                	<ul>
                    	<li>
                    		<input type="hidden" name="pageName" value="<?php echo 'login' .DS. 'index';?>"/>
                        	<label for="usn">Username : </label>
                        	<input type="text" maxlength="30"  name="username"  value="<?php if(isset($loginForm)) echo $loginForm['username'];?>"/>
                    	</li>
                    
                    	<li>
                        	<label for="passwd">Password : </label>
                        	<input type="password" maxlength="30" name="password" />
                    	</li>
                    	<li class="buttons">
                        	<input type="submit" name="loginForm" value="Login" />
                    	</li>
                    
                	</ul>
            	</form>
            	<?php include_once HOME.DS.'views'.DS.'footer.php';?>
		</div>
	</div>
<?php }?>