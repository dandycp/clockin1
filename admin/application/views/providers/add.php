<h1>Add Provider</h1>

<p>To add a new provider to your account, please ask for their Clock In Point Account Number, and enter it below.</p>

<? if ($error) : ?>
<div class="alert alert-danger"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<form class="form-horizontal" role="form" action="" method="post">
  <div class="form-group">
    <div class="col-lg-3">
       <label>Account Number</label>
      <input type="text" class="form-control" name="account_number" value="<?=$data['account_number']?>">
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-lg-10">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
  </div>
</form>
<hr />
Or you can send an email to your workforce and tell them about ClockinPoint
<hr />
<form action="<?php echo site_url(); ?>clients/providers/send_email" method="post" class="form-horizontal" role="form">
  <div class="form-group">
    <div class="col-lg-3">
      <label>Email Address</label>
      <input type="text" class="form-control" name="customer_email" value="">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-1">
      <button type="submit" class="btn btn-success">Send &raquo;</button>
    </div>
  </div>

</form>


