<?php

function __construct( $data=array() ) {
    $this->event_id = $data['event_id'];
    $this->event_time = $data['event_time'];
	$this->event_desc = $data['event_desc'];
	
	//susikonstruojam menesi
	$menesis = $data['event_month'];
	if($menesis<10) {$menesis = str_pad($menesis, 2, "0", STR_PAD_LEFT);}
	
	//susikonstruojam diena
	$diena = $data['event_day'];
	if($diena<10) {$diena = str_pad($diena, 2, "0", STR_PAD_LEFT);}
	
	$event_date = $data['event_year']."-".$menesis."-".$diena;
  }
 

 
