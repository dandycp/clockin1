<script type="text/javascript">
$(document).ready(function() {

});
</script>

<div class="col-md-4" id="login-panel">
<h4>Request Info</h4>
<?php
$error = validation_errors();


if (isset($error)) {

  '<div class="alert alert-danger" id="errorMsg"><?php echo $error; ?></div>';
  echo '<script type="text/javascript">
          $(document).ready(function() {
            $("contact-form").hide();
            $("errorMsg").show();
          });
        </script>';
}
?>
<form class="form-horizontal" role="form" method="post" action="" id="contact-form">
   <input type="hidden" name="ip" value="<?php echo $this->input->ip_address(); ?>" />
        
  <div class="form-group">
    <label for="inputEmail1" class="control-label sr-only">Contact Name</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" placeholder="Contact name" name="name">
    </div>
  </div>
    
  <div class="form-group">
    <label for="inputEmail1" class="control-label sr-only">Company</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" placeholder="Company" name="company">
    </div>
  </div>
  
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

  <input type="submit" class="btn btn-success" value="Send" name="send" id="sendForm">

</form>
</div> 