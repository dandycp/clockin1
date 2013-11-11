<?php

      		//Detect special conditions devices
      		$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
      		$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
      		$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
      		$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");

      		//do something with this information
      		if( $iPod || $iPhone ){
      		   include 'includes/panel';
      		}else if($iPad){
      		    include 'includes/panel';
      		    //browser reported as an iPad -- do something here
      		}else if($Android){
      		    //browser reported as an Android device -- do something here
              include 'includes/panel';
      		}
      		else {
      		    include 'panels';
      		}

    		?> 