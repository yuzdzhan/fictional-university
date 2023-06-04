<?php

function university_post_types()
{
		// Event post type
    register_post_type('event', array(
      'show_in_rest' => true,
      'supports' => array('title', 'editor', 'excerpt'),
      'rewrite' => array('slug' => 'events'),
      'has_archive' => true,
      'public' => true,
      'labels' => array(
        'name' => 'Events',
        'add_new_item' => 'Add new event',
        'edit_item' => 'Adit event',
        'all_items' => 'All events',
        'singular_name' => 'Event'
      ),
      'menu_icon' => 'dashicons-calendar'
    ));


		// Program post type
    register_post_type('program', array(
      'show_in_rest' => true,
      'supports' => array('title', 'editor'),
      'rewrite' => array('slug' => 'programs'),
      'has_archive' => true,
      'public' => true,
      'labels' => array(
        'name' => 'Programs',
        'add_new_item' => 'Add new program',
        'edit_item' => 'Edit program',
        'all_items' => 'All programs',
        'singular_name' => 'Program'
      ),
      'menu_icon' => 'dashicons-awards'
    ));
}

add_action('init', 'university_post_types');
