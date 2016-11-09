<?php

include_once get_template_directory() . '/homepages/homepage-class.php';

class CurrentHomepage extends Homepage {

	function __construct($options=array()) {

		$defaults = array(
			'name' => __('Current Homepage Layout', 'largo'),
			'description' => __('A homepage with top posts and widget area', 'current'),
			'template' => get_stylesheet_directory() . '/homepages/templates/current_template.php',
			'rightRail' => true,
		);
		$options = array_merge($defaults, $options);
		parent::__construct($options);
	}

	function railWidget() {

		$widget = "<div class='widget-area'>";

		if (!dynamic_sidebar('Homepage next to second post')) {
			$widget .= "<div style=''> Add a widget to the 'Homepage next to second post' sidebar</div>";
		}

		$widget .= "</div>";
		return $widget;
	}

}
