<?
//$currentFile = $_SERVER["PHP_SELF"];
//$parts = explode('/', $currentFile);
//$pagename = $parts[count($parts) - 1];
?>
<!--
    <nav class="navbar navbar-inverse" role="navigation">
      <ul class="nav">
        <li <?=$pagename == "index.php"? " class='active'" : "";?>><a href="index.php">Home</a></li>  
        <li <?=$pagename == "howitworks.php"? " class='active'" : "";?>><a href="howitworks.php">How it Works</a></li>
        <li <?=$pagename == "benefits.php"? " class='active'" : "";?>><a href="benefits.php">Benefits</a></li>
        <li <?=$pagename == "applications.php"? " class='active'" : "";?>><a href="applications.php">Applications</a></li>
        <li <?=$pagename == "wheretobuy.php"? " class='active'" : "";?>><a href="wheretobuy.php">Where to Buy</a></li>
        <li <?=$pagename == "contact.php"? " class='active'" : "";?>><a href="contact.php">Contact Us</a></li>
      </ul>
    </nav>
-->


<?php if ($this->uri->segment(1) == 'howitworks'); ?>
<nav class="navbar" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
        <li <?php if ($this->uri->segment(1) == 'home' || $this->uri->segment(1) == '') { echo 'class="active"'; } else {} ?>><a href="home">Home</a></li>  
        <li <?php if ($this->uri->segment(1) == 'howitworks') { echo 'class="active"'; } else {} ?>><a href="howitworks">How it Works</a></li>
        <li <?php if ($this->uri->segment(1) == 'benefits') { echo 'class="active"'; }else {} ?>><a href="benefits">Benefits</a></li>
        <li <?php if ($this->uri->segment(1) == 'applications') { echo 'class="active"'; }else {} ?>><a href="applications">Applications</a></li>
        <li <?php if ($this->uri->segment(1) == 'wheretobuy') { echo 'class="active"'; }else {} ?>><a href="wheretobuy">Where to Buy</a></li>
        <li <?php if ($this->uri->segment(1) == 'contact') { echo 'class="active"'; }else {} ?>><a href="contact">Contact Us</a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
