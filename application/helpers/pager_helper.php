<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



function pager($base_url, $model)
{
	$CI = & get_instance();

	$pager = '<ul class="pagination pagination-small">';

	if ($previous_page = $CI->$model->previous_page)
	{
		$pager .= '<li><a class="btn" href="' . $base_url . '/pg/0" title="First">First</a></li>';
		$pager .= '<li><a class="btn" href="' . $base_url . '/pg/' . $CI->$model->previous_offset . '" title="Previous"><</a></li>';
	}
	else
	{
		$pager .= '<li><a class="btn disabled" href="#" title="First">First</a></li>';
		$pager .= '<li><a class="btn disabled" href="#" title="Previous"><</a></li>';
	}

	if ($next_page = $CI->$model->next_page)
	{
		$pager .= '<li><a class="btn" href="' . $base_url . '/pg/' . $CI->$model->next_offset . '" title="Next">></a></li>';
		$pager .= '<li><a class="btn" href="' . $base_url . '/pg/' . $CI->$model->last_offset . '" title="Last">Last</a></li>';
	}
	else
	{
		$pager .= '<li><a class="btn disabled" href="#" title="Next">></a></li>';
		$pager .= '<li><a class="btn disabled" href="#" title="Last">Last</a></li>';
	}
	
	$pager .= '</ul>';
	
	return $pager;

}

?>