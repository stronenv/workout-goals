<?php

// Register Custom Post Type
function register_workout_goals() {

	$labels = array(
		'name'                  => _x( 'Workout Goals', 'Post Type General Name', 'workout-goals' ),
		'singular_name'         => _x( 'Workout Goal', 'Post Type Singular Name', 'workout-goals' ),
		'menu_name'             => __( 'Goals', 'workout-goals' ),
		'name_admin_bar'        => __( 'Goal', 'workout-goals' ),
		'archives'              => __( 'Workout Goal Archives', 'workout-goals' ),
		'attributes'            => __( 'Workout Goal Attributes', 'workout-goals' ),
		'parent_item_colon'     => __( 'Parent Item:', 'workout-goals' ),
		'all_items'             => __( 'All Workout Goals', 'workout-goals' ),
		'add_new_item'          => __( 'Add New Goal', 'workout-goals' ),
		'add_new'               => __( 'Add Goal', 'workout-goals' ),
		'new_item'              => __( 'New Goal', 'workout-goals' ),
		'edit_item'             => __( 'Edit Goal', 'workout-goals' ),
		'update_item'           => __( 'Update Goal', 'workout-goals' ),
		'view_item'             => __( 'View Goal', 'workout-goals' ),
		'view_items'            => __( 'View Goals', 'workout-goals' ),
		'search_items'          => __( 'Search Goal', 'workout-goals' ),
		'not_found'             => __( 'Not found', 'workout-goals' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'workout-goals' ),
		'featured_image'        => __( 'Featured Image', 'workout-goals' ),
		'set_featured_image'    => __( 'Set featured image', 'workout-goals' ),
		'remove_featured_image' => __( 'Remove featured image', 'workout-goals' ),
		'use_featured_image'    => __( 'Use as featured image', 'workout-goals' ),
		'insert_into_item'      => __( 'Insert into goal', 'workout-goals' ),
		'uploaded_to_this_item' => __( 'Uploaded to this goal', 'workout-goals' ),
		'items_list'            => __( 'Goals list', 'workout-goals' ),
		'items_list_navigation' => __( 'Workout Goals list navigation', 'workout-goals' ),
		'filter_items_list'     => __( 'Filter goals list', 'workout-goals' ),
	);

	$rewrite = array(
		'slug'       => 'goals',
		'with_front' => true,
		'pages'      => true,
		'feeds'      => true,
	);

	$args = array(
		'label'               => __( 'Workout Goal', 'workout-goals' ),
		'description'         => __( 'Create a goal and track your progress', 'workout-goals' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'comments', 'custom-fields' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-superhero-alt',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
		'show_in_rest'        => true,
	);
	register_post_type( 'workout_goals', $args );

}
add_action( 'init', 'register_workout_goals', 0 );

//Register Meta fields
register_post_meta(
	'workout_goals',
	'workout_goals_goal_distance',
	array(
		'type'         => 'number',
		'description'  => 'The Workout Goals distance based on Map input',
		'single'       => 'true',
		'show_in_rest' => true,
	)
);

register_post_meta(
	'workout_goals',
	'workout_goals_goal_duration',
	array(
		'type'         => 'number',
		'description'  => 'The Workout Goals duration based on Map input',
		'single'       => 'true',
		'show_in_rest' => true,
	)
);
