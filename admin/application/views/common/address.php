  	<div class="form-group">
  		<div class="col-lg-8">
    	<label >Address</label>
      			<input type="text" class="form-control" name="address[line_1]" value="<?php echo $address['line_1'];?>">
    		</div>
  	</div>


	  <div class="form-group">
	  	<div class="col-lg-8">
	  	<label>Address (optional)</label>
	      <input type="text" class="form-control" name="address[line_2]" value="<?php echo $address['line_2'];?>">
	    </div>
	  </div>

	  <div class="form-group">
	  	<div class="col-lg-8">
	    <label>City/Town</label>
	    
	      <input type="text" class="form-control" name="address[city]" value="<?php echo $address['city'];?>">
	    </div>
	  </div>

	  <div class="form-group">
	  	<div class="col-lg-8">
	    <label>Postcode</label>
	    
	      <input type="text" class="form-control" name="address[postcode]" value="<?php echo $address['postcode'];?>">
	    </div>
	  </div>

	  <div class="form-group">
	  	<div class="col-lg-6">
	    <label>Country</label>
	    
	      <select name="address[country_id]" class="form-control">
			<? foreach ($countries as $country) : ?>
			<option value="<?php echo $country['id'];?>"  <? if ($address['country_id'] == $country['id']) echo 'selected="selected"' ?>>
			<?php echo $country['name'];?>
			</option>
			<? endforeach ?>
		</select>
	    </div>
	  </div>