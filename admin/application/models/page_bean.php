<?php 

class Model_Page extends RedBean_SimpleModel {

	public function open()
	{
		if (empty($this->meta_title)) $this->meta_title = $this->title;
		
		$parent_id = $this->parent_id;
		$this->full_slug = $this->slug;
		$this->depth = 0;
		$this->section_slug = $this->slug;
		$ancestors = array();
		
		while ($parent_id > 1) {
			$item = R::load('page', $parent_id);
			$parent_id = $item->parent_id;
			$this->full_slug = $item->slug . '/' . $this->full_slug;
			array_unshift($ancestors, $item);
			$this->depth++;
			$this->section_slug = $item->slug;
		}
		
		if ($this->type == 'external_link') $this->full_slug = $this->url;
		else $this->full_slug = '/' . $this->full_slug;
		
		$this->ancestors = $ancestors;
		
	}

}