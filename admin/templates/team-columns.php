<?php
if ( !function_exists( 'sportspress_team_columns' ) ) {
	function sportspress_team_columns( $id = null ) {

		if ( ! $id ):
			global $post;
			$id = $post->ID;
		endif;

		$leagues = get_the_terms( $id, 'sp_league' );

		$output = '';

		// Loop through data for each league
		foreach ( $leagues as $league ):

			$data = sportspress_get_team_columns_data( $id, $league->term_id );

			if ( sizeof( $data ) <= 1 )
				continue;

			if ( sizeof( $leagues ) > 1 )
				$output .= '<h4 class="sp-team-league-name">' . $league->name . '</h4>';

			// The first row should be column labels
			$labels = $data[0];

			// Remove the first row to leave us with the actual data
			unset( $data[0] );

			$output .= '<table class="sp-team-columns sp-data-table">' . '<thead>' . '<tr>';

			foreach( $labels as $key => $label ):
				$output .= '<th class="data-' . $key . '">' . $label . '</th>';
			endforeach;

			$output .= '</tr>' . '</thead>' . '<tbody>';

			$i = 0;

			foreach( $data as $season_id => $row ):

				$output .= '<tr class="' . ( $i % 2 == 0 ? 'odd' : 'even' ) . '">';

				foreach( $labels as $key => $value ):
					$output .= '<td class="data-' . $key . '">' . sportspress_array_value( $row, $key, '—' ) . '</td>';
				endforeach;

				$output .= '</tr>';

				$i++;

			endforeach;

			$output .= '</tbody>' . '</table>';


		endforeach;

		return apply_filters( 'sportspress_team_columns',  $output );

	}
}
