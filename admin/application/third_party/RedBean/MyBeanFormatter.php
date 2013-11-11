<?php 

class MyBeanFormatter implements RedBean_IBeanFormatter {
	
	public function formatBeanTable($type) {
		//return 'cms_'.$type;
		return $type;
	}
	
	public function formatBeanID($type) {
		return 'id';
	}
	
	public function getAlias($field) {
		//if ($field=='student') return 'person';
		return $field;
	}
}