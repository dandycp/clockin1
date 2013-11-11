<div class="col-md-4" id="login-panel">
<h4>Request Info</h4>
<?php

if (isset($_POST['send'])) {
  $name     = $_POST['name'];
  $email    = $_POST['email'];
  $company  = $_POST['company'];
  $tel      = $_POST['tel'];

  $error = '';
  if (empty($error)){
        //The form is completed properly to do with as you please
        unset($error);
  }

  if ($_POST['name']){
        $name = $_POST['name']; 
  }
  else{
     $error = "Please enter a contact name";
  }

  if ($_POST['email']){
    $email = $_POST['email'];
  }
  else {
    $error = "You must provide an email address";
  }

}



?>

<form class="form-horizontal" role="form" method="post" action="" id="contact-form">
    <?php if (isset($error)) { 
      echo '<div class="form-group has-error"><div class="col-lg-10"><input type="text" class="form-control" id="errors" placeholder="'.$error.'" value="'.htmlentities($_POST['name']).'">
      </div></div>'; } 
    else { ?>
    <div class="form-group">
    <label for="inputEmail1" class="control-label sr-only">Contact Name</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" placeholder="Contact name" name="name">
    </div>
  </div>
  <?php } ?>
  <?php if (isset($error)) { 
      echo '<div class="form-group has-error"><div class="col-lg-10"><input type="text" class="form-control" id="errors" placeholder="'.$error.'" value="'.htmlentities($_POST['email']).'">
      </div></div>'; } 
    else { ?>
  <div class="form-group">
    <label for="inputEmail1" class="control-label sr-only">Company</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" placeholder="Company" name="company">
    </div>
  </div>
  <?php } ?>

  <div class="form-group">
    <label for="inputEmail1" class="control-label sr-only">Email Address</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" placeholder="Email address" name="email">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="control-label sr-only">Telephone Number</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" placeholder="Phone" name="tel">
    </div>
  </div>

  <input type="submit" class="btn btn-success" value="Send" name="send">

</form>
</div> 