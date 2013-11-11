<h1>Package Changed</h1>

<p><strong>Thank you - your device limit has now been changed to <?=$account->device_limit?> devices.</strong></p>


<dl class="dl">
	
	<dt>Date of change</dt>
	<dd><?=date("M d, Y @ H:i", strtotime($new_subscription->added_at))?></dd>
	
	<dt>Old Device Limit</dt>
	<dd><?=$old_subscription->num_devices?></dd>
	
	<dt>New Device Limit</dt>
	<dd><?=$new_subscription->num_devices?></dd>
	
	<dt>Old Subscription Amount</dt>
	<dd>£<?=$old_subscription->amount?></dd>
	
	<dt>New Subscription Amount</dt>
	<dd>£<?=$new_subscription->amount?></dd>
	
	<dt>Next payment</dt>
	<dd><?=date("M d, Y", strtotime($new_subscription->next_payment_due))?></dd>
	
	<dt>One-off pro-rata charge to cover current period</dt>
	<dd>£<?=$new_subscription->initial_amount?></dd>
	
	
	
</dl>
