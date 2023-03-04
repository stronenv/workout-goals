<?php

// Add custom fields after default fields above the comment box, always visible
function workout_goals_additional_fields () {

	echo'<div style="display:flex; justify-content: space-between;">';

	echo '<p class="comment-form-distance">'.
	'<label for="workout_goals_session_distance">' . __( 'Distance', 'workout-goals'  ) . '</label>' .
	'<input id="workout_goals_session_distance" name="workout_goals_session_distance" type="text" style="display:inline-block;" /><span style="margin-left: -35px;">km</span></p>';

	echo '<p class="comment-form-duration">'.
	'<label for="workout_goals_session_duration">' . __( 'Duration', 'workout-goals' ) . '</label>' .
	'<input id="workout_goals_session_duration" name="workout_goals_session_duration" type="text" style="display:inline-block;" /><span style="margin-left: -40px;">min</span></p>';

	echo'</div><div style="display:flex; justify-content: space-between;">';

	echo '<p class="comment-form-avg_pulse">'.
	'<label for="workout_goals_session_avg_pulse">' . __( 'Average Pulse', 'workout-goals' ) . '</label>'.
	'<input id="workout_goals_session_avg_pulse" name="workout_goals_session_avg_pulse" type="text" style="display:inline-block;" /><span style="margin-left: -45px;">bpm</span></p>';

	echo '<p class="comment-form-max_pulse" style="margin-left: 1rem; margin-right: 1rem;">'.
	'<label for="workout_goals_session_max_pulse">' . __( 'Max Pulse', 'workout-goals' ) . '</label>'.
	'<input id="workout_goals_session_max_pulse" name="workout_goals_session_max_pulse" type="text" style="display:inline-block;" /><span style="margin-left: -45px;">bpm</span></p>';

	echo '<p class="comment-form-weight">'.
	'<label for="workout_goals_session_weight">' . __( 'Weight', 'workout-goals' ) . '</label>'.
	'<input id="workout_goals_session_weight" name="workout_goals_session_weight" type="text" style="display:inline-block;" /><span style="margin-left: -35px;">kg</span></p>';
	echo'</div>';
}
add_action( 'comment_form_logged_in_after', 'workout_goals_additional_fields' );
add_action( 'comment_form_after_fields', 'workout_goals_additional_fields' );


// Save the comment meta data along with comment
function workout_goals_save_comment_meta_data( $comment_id ) {
	if ( ( isset( $_POST['workout_goals_session_distance'] ) ) && ( $_POST['workout_goals_session_distance'] != '') )
	$distance = wp_filter_nohtml_kses($_POST['workout_goals_session_distance']);
	add_comment_meta( $comment_id, 'workout_goals_session_distance', $distance );

	if ( ( isset( $_POST['workout_goals_session_duration'] ) ) && ( $_POST['workout_goals_session_duration'] != '') )
	$duration = wp_filter_nohtml_kses($_POST['workout_goals_session_duration']);
	add_comment_meta( $comment_id, 'workout_goals_session_duration', $duration );

	if ( ( isset( $_POST['workout_goals_session_avg_pulse'] ) ) && ( $_POST['workout_goals_session_avg_pulse'] != '') )
	$avg_pulse = wp_filter_nohtml_kses($_POST['workout_goals_session_avg_pulse']);
	add_comment_meta( $comment_id, 'workout_goals_session_avg_pulse', $avg_pulse );

	if ( ( isset( $_POST['workout_goals_session_max_pulse'] ) ) && ( $_POST['workout_goals_session_max_pulse'] != '') )
	$max_pulse = wp_filter_nohtml_kses($_POST['workout_goals_session_max_pulse']);
	add_comment_meta( $comment_id, 'workout_goals_session_max_pulse', $max_pulse );

	if ( ( isset( $_POST['workout_goals_session_weight'] ) ) && ( $_POST['workout_goals_session_weight'] != '') )
	$weight = wp_filter_nohtml_kses($_POST['workout_goals_session_weight']);
	add_comment_meta( $comment_id, 'workout_goals_session_weight', $weight );
}
add_action( 'comment_post', 'workout_goals_save_comment_meta_data' );


//Add an edit option in comment edit screen  
function workout_goals_extend_comment_add_meta_box() {
    add_meta_box( 'title', __( 'Comment Metadata - Workout Goals' ), 'workout_goals_extend_comment_meta_box', 'comment', 'normal', 'high' );
}

function workout_goals_extend_comment_meta_box ( $comment ) {
    $distance = get_comment_meta( $comment->comment_ID, 'workout_goals_session_distance', true );
    $duration = get_comment_meta( $comment->comment_ID, 'workout_goals_session_duration', true );
	$avg_pulse = get_comment_meta( $comment->comment_ID, 'workout_goals_session_avg_pulse', true );
    $max_pulse = get_comment_meta( $comment->comment_ID, 'workout_goals_session_max_pulse', true );
	$weight = get_comment_meta( $comment->comment_ID, 'workout_goals_session_weight', true );

    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
    ?>
    <p>
        <label for="workout_goals_session_distance"><?php _e( 'Distance', 'workout-goals'  ); ?></label>
        <input type="text" name="workout_goals_session_distance" value="<?php echo esc_attr( $distance ); ?>" class="widefat" />
	</p>
	<p>
        <label for="workout_goals_session_duration"><?php _e( 'Duration', 'workout-goals'  ); ?>
        <input type="text" name="workout_goals_session_duration" value="<?php echo esc_attr( $duration ); ?>" class="widefat" /></label>
	</p>
	<p>
        <label for="workout_goals_session_avg_pulse"><?php _e( 'Average Pulse', 'workout-goals'  ); ?>
        <input type="text" name="workout_goals_session_avg_pulse" value="<?php echo esc_attr( $avg_pulse ); ?>" class="widefat" /></label>
	</p>
	<p>
        <label for="workout_goals_session_max_pulse"><?php _e( 'Max Pulse', 'workout-goals'  ); ?>
        <input type="text" name="workout_goals_session_max_pulse" value="<?php echo esc_attr( $max_pulse ); ?>" class="widefat" /></label>
	</p>
	<p>
		<label for="workout_goals_session_weight"><?php _e( 'Weight', 'workout-goals'  ); ?>
        <input type="text" name="workout_goals_session_weight" value="<?php echo esc_attr( $weight ); ?>" class="widefat" /></label>
	</p>
    <?php
}
add_action( 'add_meta_boxes_comment', 'workout_goals_extend_comment_add_meta_box' );


// Update comment meta data from comment edit screen 
function workout_goals_extend_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

	if ( ( isset( $_POST['workout_goals_session_distance'] ) ) && ( $_POST['workout_goals_session_distance'] != '') ) : 
	$distance = wp_filter_nohtml_kses($_POST['workout_goals_session_distance']);
	update_comment_meta( $comment_id, 'workout_goals_session_distance', $distance );
	else :
	delete_comment_meta( $comment_id, 'workout_goals_session_distance');
	endif;
		
	if ( ( isset( $_POST['workout_goals_session_duration'] ) ) && ( $_POST['workout_goals_session_duration'] != '') ):
	$duration = wp_filter_nohtml_kses($_POST['workout_goals_session_duration']);
	update_comment_meta( $comment_id, 'workout_goals_session_duration', $duration );
	else :
	delete_comment_meta( $comment_id, 'workout_goals_session_duration');
	endif;
	
	if ( ( isset( $_POST['workout_goals_session_avg_pulse'] ) ) && ( $_POST['workout_goals_session_avg_pulse'] != '') ):
	$avg_pulse = wp_filter_nohtml_kses($_POST['workout_goals_session_avg_pulse']);
	update_comment_meta( $comment_id, 'workout_goals_session_avg_pulse', $avg_pulse );
	else :
	delete_comment_meta( $comment_id, 'workout_goals_session_avg_pulse');
	endif;

	if ( ( isset( $_POST['workout_goals_session_max_pulse'] ) ) && ( $_POST['workout_goals_session_max_pulse'] != '') ):
	$max_pulse = wp_filter_nohtml_kses($_POST['workout_goals_session_max_pulse']);
	update_comment_meta( $comment_id, 'workout_goals_session_max_pulse', $max_pulse );
	else :
	delete_comment_meta( $comment_id, 'workout_goals_session_max_pulse');
	endif;

	if ( ( isset( $_POST['workout_goals_session_weight'] ) ) && ( $_POST['workout_goals_session_weight'] != '') ):
	$weight = wp_filter_nohtml_kses($_POST['workout_goals_session_weight']);
	update_comment_meta( $comment_id, 'workout_goals_session_weight', $weight );
	else :
	delete_comment_meta( $comment_id, 'workout_goals_session_weight');
	endif;
}
add_action( 'edit_comment', 'workout_goals_extend_comment_edit_metafields' );


// Add the comment meta to the comment text 
function workout_goals_modify_comment_text($comment_text, $comment, $args) { 

	if ( $duration = get_comment_meta( $comment->comment_ID, 'workout_goals_session_duration', true ) ) {
		$duration = '<strong> Duration: ' . esc_attr( $duration ) . ' min</strong><br/>';
		$comment_text = $duration . $comment_text;
	}
	
	if ( $distance = get_comment_meta( $comment->comment_ID, 'workout_goals_session_distance', true ) ) {
		$distance = '<strong> Distance: ' . esc_attr( $distance ) . ' km</strong><br/>';
		$comment_text = $distance . $comment_text;
	} 

	if ( $avg_pulse = get_comment_meta( $comment->comment_ID, 'workout_goals_session_avg_pulse', true ) ) {
		$avg_pulse = '<strong> Average Pulse: ' . esc_attr( $avg_pulse ) . ' bpm</strong><br/>';
		$comment_text = $avg_pulse . $comment_text;
	} 

	if ( $max_pulse = get_comment_meta( $comment->comment_ID, 'workout_goals_session_max_pulse', true ) ) {
		$max_pulse = '<strong> Max Pulse: ' . esc_attr( $max_pulse ) . ' bpm</strong><br/>';
		$comment_text = $max_pulse . $comment_text;
	} 

	if ( $weight = get_comment_meta( $comment->comment_ID, 'workout_goals_session_weight', true ) ) {
		$weight = '<strong> Weight: ' . esc_attr( $weight ) . ' kg</strong><br/>';
		$comment_text = $weight . $comment_text;
	} 

	return $comment_text;

}
add_filter( 'comment_text', 'workout_goals_modify_comment_text', 10, 3 );
