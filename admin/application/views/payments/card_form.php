
	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-1 control-label">Card Type</label>
	    <div class="col-lg-3">
	      <select name="type" class="form-control">
				<option value="">Please select&hellip;</option>
				<option value="MAESTRO"<? if ($card->type == 'MAESTRO') echo ' selected'?>>Maestro</option>
				<option value="MASTERCARD"<? if ($card->type == 'MASTERCARD') echo ' selected'?>>Mastercard</option>
				<option value="VISA"<? if ($card->type == 'VISA') echo ' selected'?>>Visa</option>
			</select>
	    </div>
  	</div>


	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-1 control-label">Card Number</label>
	    <div class="col-lg-3">
	      <input type="text" name="number" value="<?=$card->number?>" class="form-control">
	    </div>
  	</div>


	<div class="form-group form-inline">
    	<label for="inputEmail1" class="col-lg-1 control-label">Expires</label>
	    <div class="col-lg-1">
	      <input type="number" width="2" maxlength="2" placeholder="MM" class="form-control" name="expires_m" value="<?=$card->expires_m?>">/<input type="number" width="2" maxlength="2" placeholder="YY" class="form-control" name="expires_y" value="<?=$card->expires_y?>">
	    </div>
  	</div>


	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-1 control-label">Cardholder Name</label>
	    <div class="col-lg-3">
	     <input type="text" name="name" value="<?=$card->name?>" class="form-control">
  	</div>

<br />

	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-1 control-label">3 digit Security Code</label>
	    <div class="col-lg-1">
	     <input type="number" width="3" name="csc" value="<?=$card->csc?>" class="form-control">
  	</div>

