<?php

$widget = elgg_extract('entity', $vars);

$sides = array(
	'left',
	'right'
);

$content = array();

foreach ($sides as $side) {
	$side_content = array(
		'class' => array('elgg-col'),
		'style' => '',
		'title' => '',
		'content' => ''
	);
	
	$type = $widget->get("{$side}_type");
	if (empty($type)) {
		$type = 'text';
	}
	
	$link = $widget->get("{$side}_link");
	$wrapper_title = $widget->get("{$side}_wrapper_text");
	if (!empty($wrapper_title)) {
		$side_content['title'] = $wrapper_title;
	}
	
	if ($type === 'text') {
		$text = $widget->get("{$side}_text");
		
		if (empty($text)) {
			continue;
		}
		
		if (!empty($link)) {
			$side_content['content'] = elgg_view('output/url', array(
				'href' => $link,
				'text' => elgg_view('output/longtext', array('value' => $text))
			));
		} else {
			$side_content['content'] = elgg_view('output/longtext', array('value' => $text));
		}
		
		$background = $widget->get("{$side}_background");
		if (!empty($background)) {
			$side_content['class'][] = $background;
		}
	} elseif($type === 'image') {
		$image = $widget->get("{$side}_image");
		
		if (empty($image)) {
			continue;
		}
		
		if (!empty($link)) {
			$side_content['content'] = elgg_view('output/url', array(
				'href' => $link,
			));
		}
		
		$side_content['class'][] = 'promo-widget-type-image';
		$side_content['style'] = 'background: url(' . elgg_normalize_url($image) . ') no-repeat;';
	} else {
		// shouldn't happen
		continue;
	}
	
	$content[] = $side_content;
}

foreach ($content as $side_content) {
	
	$c = elgg_extract('content', $side_content);
	unset($side_content['content']);
	
	$side_content['class'][] = 'elgg-col-1of' . count($content);
		
	echo '<div ' . elgg_format_attributes($side_content) . '>';
	echo $c;
	echo '</div>';
}
