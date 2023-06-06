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
        'edit_item' => 'Edit event',
        'all_items' => 'All events',
        'singular_name' => 'Event'
      ),
      'menu_icon' => 'dashicons-calendar'
    ));


		// Program post type
    register_post_type('program', array(
      'show_in_rest' => true,
      'supports' => array('title'),
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

		// Professor post type
    register_post_type('professor', array(
      'show_in_rest' => true,
      'supports' => array('title', 'editor', 'thumbnail'),
      'public' => true,
      'labels' => array(
        'name' => 'Professors',
        'add_new_item' => 'Add new professor',
        'edit_item' => 'Edit professor',
        'all_items' => 'All professors',
        'singular_name' => 'Professor'
      ),
      'menu_icon' => 'dashicons-welcome-learn-more'
    ));
}

add_action('init', 'university_post_types');
