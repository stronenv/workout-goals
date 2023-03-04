<?php

function workout_goals_modify_post_meta( $post_ID, $post ) {

	// Check that we're only modifying Workout Goals
	if ( 'workout_goals' === $post->post_type ) {

		//Get the Maps block
		foreach ( parse_blocks( $post->post_content ) as $block ) {

			if ( 'styled-google-maps-block/main-block' === $block['blockName'] ) {

				//Get the block attributes
				$map_attrs = $block['attrs'];

				//Fetch more data and store it in Post Meta
				$url  = 'https://maps.googleapis.com/maps/api/directions/json';
				$url .= '?origin=' . rawurlencode( $map_attrs['origin'] );
				$url .= '&destination=' . rawurlencode( $map_attrs['destination'] );
				$url .= '&mode=' . rawurlencode( $map_attrs['mode'] );
				$url .= '&key=' . $map_attrs['key'];

				$ch = curl_init( $url );

				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

				$res = curl_exec( $ch );

				if(curl_error($ch)) {
					var_dump(curl_error($ch));
				}
				$json = json_decode( $res );
				update_post_meta( $post_ID, 'workout_goals_goal_duration', round( $json->routes[0]->legs[0]->duration->value / 60 / 60, 2 ) );
				update_post_meta( $post_ID, 'workout_goals_goal_distance', round( $json->routes[0]->legs[0]->distance->value / 1000 ) );
				curl_close($ch);

			}
		}
	}
}
add_action( 'save_post', 'workout_goals_modify_post_meta', 10, 2 );
