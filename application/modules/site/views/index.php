      <?php if ($this->agent->is_mobile()) { ?>
        <div class="feature-img"><img src="img/feature-image.gif" class="img-responsive" width="40%"></div>
         <?php 
          $sess = isset($_COOKIE['ci_session']); //? unserialize($_COOKIE['ci_session']) : array()
          $user_id = !empty($sess['user_id']) ? $sess['user_id'] : 0 ;
          $logged_in = $user_id ? true : false ;
          
          ?>
      
          <!--<div class="login-box" id="login-panel">
            <? if (!$logged_in) : ?>
            <h4>Login</h4>
            <form class="form-horizontal" role="form" method="post" action="<?php echo site_url();?>admin/clients/login">
            <div class="form-group">
            <label for="inputEmail1" class="control-label sr-only">Email</label>
            <div class="col-lg-10">
            <input type="email" class="form-control" id="inputEmail1" placeholder="Email address" name="email">
            </div>
            </div>

            <div class="form-group">
            <label for="inputEmail1" class="control-label sr-only">Password</label>
            <div class="col-lg-10">
            <input type="password" class="form-control" id="inputEmail1" placeholder="Password" name="password">
            </div>
            </div>

            <button type="submit" class="btn btn-danger">Login</button>

            </form>
            <br />
            <img src="img/bullet.gif" width="17" height="17"> <a href="admin/clients/create">Create an account</a><br />
            <img src="img/bullet.gif" width="17" height="17"> <a href="admin/clients/forgot_password">Forgotten username/password</a>

            <? else : ?>

            <p>You are currently logged in.</p>
            <p><a class="btn btn-danger" href="<?php echo site_url(); ?>admin/clients/welcome">Return to Control Panel</a></p>
            <p><a class="btn btn-success" href="<?php echo site_url(); ?>admin/clients/logout">Logout</a></p>
            <? endif ?>
          </div> -->
        

      <div class="row marketing pull-left">
        <div class="col-lg-13">
          <div class="padding"><h1>The most cost effective time &amp; attendance system available&nbsp;&#45;&nbsp;<span class="red-text">at the touch of a button...</span></h1>
                </div>
                    <p class="front">ClockinPoint is an innovative, low cost attendance validation system which can be used to monitor contractual time, ensure accuracy of account payments, detect under or over performance, reveal absence and lateness, identify anomalies and provide supporting evidence.</p>
                    
        </div>
      </div>

      <?php } else { ?>
      
        <div class="feature-img"><img src="img/feature-image.gif" class="img-responsive"></div>
         <?php 
          $sess = isset($_COOKIE['ci_session']); //? unserialize($_COOKIE['ci_session']) : array()
          $user_id = !empty($sess['user_id']) ? $sess['user_id'] : 0 ;
          $logged_in = $user_id ? true : false ;
          
          ?>
      
          <div class="login-box" id="login-panel">
            <? if (!$logged_in) : ?>
            <h4>Login</h4>
            <form class="form-horizontal" role="form" method="post" action="<?php echo site_url();?>admin/clients/login">
            <div class="form-group">
            <label for="inputEmail1" class="control-label sr-only">Email</label>
            <div class="col-lg-10">
            <input type="email" class="form-control" id="inputEmail1" placeholder="Email address" name="email">
            </div>
            </div>

            <div class="form-group">
            <label for="inputEmail1" class="control-label sr-only">Password</label>
            <div class="col-lg-10">
            <input type="password" class="form-control" id="inputEmail1" placeholder="Password" name="password">
            </div>
            </div>

            <button type="submit" class="btn btn-danger">Login</button>

            </form>
            <br />
            <img src="img/bullet.gif" width="17" height="17"> <a href="admin/clients/create">Create an account</a><br />
            <img src="img/bullet.gif" width="17" height="17"> <a href="admin/clients/forgot_password">Forgotten username/password</a>

            <? else : ?>

            <p>You are currently logged in.</p>
            <p><a class="btn btn-danger" href="<?php echo site_url(); ?>admin/clients/welcome">Return to Control Panel</a></p>
            <p><a class="btn btn-success" href="<?php echo site_url(); ?>admin/clients/logout">Logout</a></p>
            <? endif ?>
          </div> 
        

      <div class="row marketing pull-left">
        <div class="col-lg-13">
          <div class="padding"><h1>The most cost effective time &amp; attendance system available&nbsp;&#45;&nbsp;<span class="red-text">at the touch of a button...</span></h1>
                </div>
                    <p class="front">ClockinPoint is an innovative, low cost attendance validation system which can be used to monitor contractual time, ensure accuracy of account payments, detect under or over performance, reveal absence and lateness, identify anomalies and provide supporting evidence.</p>
                    
        </div>
      </div>
      <?php } ?>