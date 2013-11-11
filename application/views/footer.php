

    <?php if ($this->agent->is_mobile()) { ?>
        <div class="row pull-left">
        <div class="col-md-4 panel panel-first panel-red"><h2>Public Sector</h2><p>Multiple applications in providing<br />evidence of attendance, <br />eliminating
            invoicing fraud and <br />overpayments. <a href="applications">View more &raquo;</a></p></div>
        <div class="col-md-4 panel panel-black"><h2>Business Use</h2><p>Log the attendance of <br />sub-contract, flexitime, <br />full/part-time and freelance workers.<br />Generate online record sheets. <a href="applications">View more &raquo;</a></p></div>
        <div class="col-md-4 panel panel-grey"><h2>Home Use</h2><p>A simple and mutually reassuring<br />system for recording the <br />attendance hours of <br />domestic staff and trade workers. <a href="applications">View more &raquo;</a></p></div>
    </div>
    <?php } else { ?>



    <?php if ($this->uri->segment(1) == 'contact') { echo ''; } else { ?>
    <div class="row pull-left">
        <div class="col-md-4 panel panel-first panel-red"><h2>Public Sector</h2><p>Multiple applications in providing<br />evidence of attendance, <br />eliminating
            invoicing fraud and overpayments. <a href="applications">View more &raquo;</a></p></div>
        <div class="col-md-4 panel panel-black"><h2>Business Use</h2><p>Log the attendance of <br />sub-contract, flexitime, <br />full/part-time and freelance workers.  Generate online record sheets.<br /><a href="applications">View more &raquo;</a></p></div>
        <div class="col-md-4 panel panel-grey"><h2>Home Use</h2><p>A simple and mutually reassuring<br />system for recording the <br />attendance hours of domestic staff and trade workers. <br /><a href="applications">View more &raquo;</a></p></div>
    </div>
    
      
    <?php } }?>






	<div class="footer">
        <p>&copy; <?php echo date('Y'); ?> ClockinPoint&trade;<br />
        All rights reserved.</p>
      </div>

    </div> <!-- /container -->
    <!-- Analytics -->
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-36559933-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  </body>
</html>