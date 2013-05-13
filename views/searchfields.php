<div>
	<fieldset>
		<div class="tabular">
			<span>Buddy Name: </span><input name="name"  type="text"><br>
		</div>
		<div class="tabular">
			<span>Owner: </span>
			<select name="owner">
				<option value=""></option>
					<?php 
					if($dashboards):
					foreach ($dashboards as $dashboard):?>
							<option value="<?php echo $dashboard->id?>"><?php echo $dashboard->name?></option>
					<?php 
					endforeach;
					endif;?>
			</select>
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
</div>
