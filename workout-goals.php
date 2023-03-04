<?php
/**
 * Plugin Name: Workout Goals
 * Version: 1.0.0
 * Description: Track your workout goals
 * Author: stronenv
 * Author URI: https://profiles.wordpress.org/vevas/
 *
 * Text Domain: workout-goals
 *
 * @package WordPress
 * @author Vegard S.
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Create Custom Post Type Workout Goals, Post Meta, and Comments Meta
require_once 'includes/register-post-type.php';
require_once 'includes/comment-meta-fields.php';
require_once 'includes/modify-post-meta.php';

//Display
require_once 'includes/post-content-display.php';


//Load scripts
function workout_goals_enqueue_script() {
	wp_enqueue_script( 'chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), '4.2.1', true );
	wp_enqueue_script( 'workout-goals-js', plugin_dir_url( __FILE__ ) . 'assets/js/workout-goals.js', array(), time(), true );
}
add_action( 'wp_enqueue_scripts', 'workout_goals_enqueue_script' );
//add_action( 'admin_enqueue_scripts', 'workout_goals_enqueue_script' );
