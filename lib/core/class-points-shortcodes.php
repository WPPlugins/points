<?php
/**
* class-points-shortcodes.php
*
* Copyright (c) 2010-2012 "eggemplo" Antonio Blanco Oliva www.eggemplo.com
*
* This code is released under the GNU General Public License.
* See COPYRIGHT.txt and LICENSE.txt.
*
* This code is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This header and all notices must be kept intact.
*
* @author Antonio Blanco Oliva
* @package points
* @since points 1.0
*/
class Points_Shortcodes {

	/**
	 * Add shortcodes.
	 */
	public static function init() {

		add_shortcode( 'points_users_list', array( __CLASS__, 'points_users_list' ) );
		add_shortcode( 'points_user_points', array( __CLASS__, 'points_user_points' ) );

	}

	public static function points_users_list ( $atts, $content = null ) {
		$options = shortcode_atts(
				array(
						'limit'  => 10,
						'order_by' => 'points',
						'order' => 'DESC'
				),
				$atts
		);
		extract( $options );
		$output = "";

		$pointsusers = Points::get_users();

		if ( sizeof( $pointsusers )>0 ) {
			foreach ( $pointsusers as $pointsuser ) {
				$total = Points::get_user_total_points( $pointsuser );
				$output .='<div class="points-user">';
				$output .= '<span class="points-user-username">';
				$output .= get_user_meta ( $pointsuser, 'nickname', true );
				$output .= ':</span>';
				$output .= '<span class="points-user-points">';
				$output .= " ". $total . " " . get_option('points-points_label', POINTS_DEFAULT_POINTS_LABEL);
				$output .= '</span>';
				$output .= '</div>';
			}
		} else {
			$output .= '<p>No users</p>';
		}

		return $output;
	}

	public static function points_user_points ( $atts, $content = null ) {
		$output = "";

		$options = shortcode_atts(
				array(
						'id'  => ""
				),
				$atts
		);
		extract( $options );

		//echo 'ID:' . $id . "-" . $options['id'];

		if ( $id == "" ) {
			$id = get_current_user_id();
		}

		if ( $id !== 0 ) {
			$points = Points::get_user_total_points( $id, POINTS_STATUS_ACCEPTED );
			$output .= $points;
		}

		return $output;
	}

}
Points_Shortcodes::init();
