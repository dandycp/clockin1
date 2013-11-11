<div class="row"><div class="span12 header"><a href="index.php" class="logo"><span>Clock In Point</span></a></div></div>

		<?
			$currentFile = $_SERVER["PHP_SELF"];
			$parts = Explode('/', $currentFile);
			$pagename = $parts[count($parts) - 1];

		?>

	<div class="navbar">
        <div class="navbar-inner">     
            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span style="color: #000; margin: 0 auto; width: 100%;">Show Menu</span>
            </a>
     
            <!-- Everything you want hidden at 940px or less, place within here -->
            <div class="nav-collapse collapse">
            <!-- .nav, .navbar-search, .navbar-form, etc -->
              <ul class="nav">
                <li <?=$pagename == "index.php"? " class='active'" : "";?>><a href="index.php">Home</a></li>  
                <li <?=$pagename == "howitworks.php"? " class='active'" : "";?>><a href="howitworks.php">How it Works</a></li>
                <li <?=$pagename == "benefits.php"? " class='active'" : "";?>><a href="benefits.php">Benefits</a></li>
                <li <?=$pagename == "applications.php"? " class='active'" : "";?>><a href="applications.php">Applications</a></li>
                <li <?=$pagename == "wheretobuy.php"? " class='active'" : "";?>><a href="wheretobuy.php">Where to Buy</a></li>
                <li <?=$pagename == "contact.php"? " class='active'" : "";?>><a href="contact.php">Contact Us</a></li>
              </ul>
            </div>
     
          
        </div>
      </div>