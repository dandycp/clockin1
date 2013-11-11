<div <?php /*?>onload="document.forms['worldpay-form'].submit();"<?php */?>>

<form name="worldpay-form" action="<?=$worldpay->payment_url?>" method="post">

<!-- This next line contains a mandatory parameter. Put your Installation ID inside the quotes after value= -->
<input type="hidden" name="instId" value="<?=$worldpay->installation_id?>" />

<!-- This next line contains the testMode parameter - it specifies that the submission is a test submission -->
<input type="hidden" name="testMode" value="<?=$worldpay->test_mode?>" />

<!--This is where the payment response gets sent to-->
<input type="hidden" name="MC_callback" value="<?=$worldpay->callback?>" />

<!-- Another mandatory parameter. Put your own reference identifier for the item purchased inside the quotes after value= -->
<input type="hidden" name="cartId" value="<?=$transaction_id?>" />

<!-- Another mandatory parameter. Put the total cost of the item inside the quotes after value= -->
<input type="hidden" name="amount" value="<?=$amount?>" />

<!-- Another mandatory parameter. Put the code for the purchase currency inside the quotes after value= -->
<input type="hidden" name="currency" value="<?=$worldpay->currency?>" />

<!-- Only show GBP -->
<input type="hidden" name="hideCurrency" value="true" />

<!-- FuturePay (Recurring Billing) -->
<input type="hidden" name="futurePayType" value="regular">
<input type="hidden" name="option" value="0">
<input type="hidden" name="startDelayMult" value="1">
<input type="hidden" name="startDelayUnit" value="<?=$frequency?>">
<input type="hidden" name="noOfPayments" value="<?=$num_payments?>">
<input type="hidden" name="intervalMult" value="1">
<input type="hidden" name="intervalUnit" value="<?=$frequency?>">
<input type="hidden" name="normalAmount" value="<?=$amount?>">
<input type="hidden" name="initialAmount" value="<?=$amount?>">

<!-- This creates the button. When it is selected in the browser, the form submits the purchase details to us. -->
<input type="submit" value="Redirecting..." />

</form>

</div>
