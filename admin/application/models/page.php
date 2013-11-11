<?php 

// include our red bean model
require_once APPPATH . 'models/page_bean.php';

class Page extends CI_Model {
	
	function get_homepage()
	{
		$item = R::findOne('page', "id=1");
		return $item; 
	}
	
	function get_by_id($id) 
	{
		$item = R::findOne('page', "id='$id' AND status=1");
		return $item;
	}
	
	function get_by_slug($slug) 
	{
		$item = R::findOne('page', "slug='$slug' AND status=1");
		return $item;
	}
	
	function get($key)
	{
		return (is_int($key)) ? $this->get_by_id($key) : $this->get_by_slug($key);
	}
	
	function get_children($item)
	{
		$items = R::find('page', "parent_id='{$item->id}' AND status=1 ORDER BY lft");
		return $items;
	}
	
	function get_children_by_slug($slug)
	{
		$item = $this->get_by_slug($slug);
		$items = $this->get_children($item);
		return $items;
	}
	
	function get_section_pages($page) 
	{
		// find out who the top level parent is
		$slug = $page->section_slug;
		$section_parent = $this->get_by_slug($slug);
		$items = R::find('page', "lft BETWEEN {$section_parent->lft} AND {$section_parent->rgt} AND status = 1 ORDER BY lft");
		return $items;
	}
	
	function get_menu_cols($slug)
	{
		$cols = array();
		$page = $this->get_by_slug($slug);
		$children = $this->get_children($page);
		if (count($children) == 0) return $cols;
		$num_cols = (count($children) > 7) ? 2 : 1;
		$length = ceil(count($children)/$num_cols);
		//echo 'length = ' . $length . '<br>';
		for ($i=0; $i < $num_cols; $i++) {
			$offset = $i * $length;
			//echo 'offset = ' . $offset . '<br>';
			$cols[] = array_slice($children, $offset, $length);
		}
		return $cols;
	}
	
	function render_tree($tree=array())
	{
		$current_depth = 0;
		$counter = 0;
		$result = '<ul>';
		
		foreach ($tree as $node) {
		
			// skip any that shouldn't be shown
			if ($node->show_in_nav == 0) continue;
			
			$node_depth = $node->depth;
			$node_name = $node->short_title;
			
			if ($node_depth == $current_depth) {
				if ($counter > 0) $result .= '</li>';            
			}
			elseif ($node_depth > $current_depth) {
				$result .= '<ul>';
				$current_depth = $current_depth + ($node_depth - $current_depth);
			}
			elseif ($node_depth < $current_depth) {
				$result .= str_repeat('</li></ul>', $current_depth - $node_depth).'</li>';
				$current_depth = $current_depth - ($current_depth - $node_depth);
			}
			$other_attributes = '';
			if (($node->type == 'external_link' && substr($node->url,0,1)!='/') || substr($node->url,0,4)=='/360') $other_attributes = ' target="_blank"';
			$class = ($counter==0) ? ' class="first"' : '' ;
			$result .= '<li'.$class.' id="subnav-link-'.str_replace('/', '-', $node->full_slug).'"><a href="'.$node->full_slug.'"' . $other_attributes .'>'.$node_name.'</a>';
			$counter++;
		}
		$result .= str_repeat('</li></ul>',$node_depth).'</li></ul>';
		
		return $result;
	}

}