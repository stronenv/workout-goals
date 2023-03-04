<?php

function workout_data( $post_ID ) {
	var_dump( get_comments() );
}

function convertTime($dec)
{
    // start by converting to seconds
    $seconds = ($dec * 3600);
    // we're given hours, so let's get those the easy way
    $hours = floor($dec);
    // since we've "calculated" hours, let's remove them from the seconds variable
    $seconds -= $hours * 3600;
    // calculate minutes left
    $minutes = floor($seconds / 60);
    // remove those from seconds as well
    $seconds -= $minutes * 60;
    // return the time formatted HH:MM
    return lz($hours).":".lz($minutes);
}

// lz = leading zero
function lz($num)
{
    return (strlen($num) < 2) ? "0{$num}" : $num;
}

//Add Workout Data to Goal post
function filter_the_content_in_the_main_loop( $content ) {
	global $wp_query;

	// Check if it's a workout goal and that we're in the main query
	if ( 'workout_goals' === get_post_type( $wp_query->post->ID ) && in_the_loop() && is_main_query() ) {

		//Get Goal variables
		$goal_distance = get_post_meta( $wp_query->post->ID, 'workout_goals_goal_distance', true );
		$goal_duration = get_post_meta( $wp_query->post->ID, 'workout_goals_goal_duration', true );

		//Set variables
		$total_duration = 0;
		$total_distance = 0;
		$html           = '';

		//Get the comments
		$comments = get_comments( array( 'order' => 'ASC' ) );
		$avg_pulse_chart = array( 'labels' => array(), 'data' => array() );
		$max_pulse_chart = array( 'labels' => array(), 'data' => array() );
		$weight_chart = array( 'labels' => array(), 'data' => array() );

		foreach ( $comments as $comment ) {

			$duration = get_comment_meta( $comment->comment_ID, 'workout_goals_session_duration', true );
			$distance = get_comment_meta( $comment->comment_ID, 'workout_goals_session_distance', true );
			$avg_pulse = get_comment_meta( $comment->comment_ID, 'workout_goals_session_avg_pulse', true );
			$max_pulse = get_comment_meta( $comment->comment_ID, 'workout_goals_session_max_pulse', true );
			$weight = get_comment_meta( $comment->comment_ID, 'workout_goals_session_weight', true );
			$date = date( 'Y-m-d', strtotime( $comment->comment_date ) );


			if ( $duration ) {
				$total_duration += intval( $duration );
			}
			if ( $distance ) {
				$total_distance += intval( $distance );
			}
			if ( $avg_pulse ) {
				array_push($avg_pulse_chart['labels'], $date);
				array_push($avg_pulse_chart['data'], $avg_pulse);
			}
			if ( $max_pulse ) {
				array_push($max_pulse_chart['labels'], $date);
				array_push($max_pulse_chart['data'], $max_pulse);
			}
			if ( $weight ) {
				array_push($weight_chart['labels'], $date);
				array_push($weight_chart['data'], $weight);
			}
		}
		?>	
		<script>
			avgPulseChartData = {
				labels: <?php echo json_encode($avg_pulse_chart['labels']); ?>,
				datasets: [{
					label: "Avgerage Pulse",
					data: <?php echo json_encode($avg_pulse_chart['data']); ?>
				}]
			}

			maxPulseChartData = {
				labels: <?php echo json_encode($max_pulse_chart['labels']); ?>,
				datasets: [{
					label: "Max Pulse",
					data: <?php echo json_encode($max_pulse_chart['data']); ?>
				}]
			}

			weightChartData = {
				labels: <?php echo json_encode($weight_chart['labels']); ?>,
				datasets: [{
					label: "Weight",
					data: <?php echo json_encode($weight_chart['data']); ?>
				}]
			}
		
		</script>
		<?php

		$distance_progress = ( $total_distance / $goal_distance ) * 100;
		$duration_progress = ( round( $total_duration / 60, 2 ) / $goal_duration ) * 100;

		//TODO: Are you on track? compare distance to time spent outout RYG dot
		//$duration_distance_compare = round( $distance_progress - $duration_progress, 2 );

		$html .= '<div>';
		$html .= '<h3>' . esc_html__( 'Progress', 'workout-goals' ) . '</h3>';
		$html .= '<p>';
		$html .= 'Duration: ' . convertTime( $total_duration / 60 ) . ' / ' . convertTime( $goal_duration ) . ' hours <br>';
		$html .= 'Distance: ' . $total_distance . ' / ' . $goal_distance . ' km <br>';
		$html .= '<label>Progress: <progress value="' . $distance_progress . '" max="100">70 %</progress></label>';
		$html .= '</p>';
		$html .= '</div>';
		$html .= '<div><canvas id="avgPulseChart"></canvas></div>';
		$html .= '<div><canvas id="maxPulseChart"></canvas></div>';
		$html .= '<div><canvas id="weightChart"></canvas></div>';

		return $content . $html;
	}

	return $content;
}
add_filter( 'the_content', 'filter_the_content_in_the_main_loop', 1 );
