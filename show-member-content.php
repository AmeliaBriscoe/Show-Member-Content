<?php
/*
Plugin Name: Show Member Content Shortcode
Plugin URI: http://www.ameliabriscoe.com/
Version: 1.0
Author: Amelia Briscoe
Description: Show content if a member has a specific capability and was registered X days ago.
*/

/**
 * Is the current user registred for more than x days ago?
 * @param  int  $delay
 * @return bool 
 */

function acab_is_user_member( $delay = '' ){

	$cu = wp_get_current_user();   
    
   return( isset( $cu->data->user_registered ) && (strtotime( $cu->data->user_registered ) < strtotime( sprintf( '-%d days', $delay ) )) );    
     
}


add_shortcode( 'member_show',   'acab_member_shortcode' );

/**
 * Shortcode [member_show] to show content to registered members only after X amount of days
 *
 * @param  array  $atts
 * @param  string $content
 * @return string $content
 */

function acab_member_shortcode( $atts = array(), $content = '' ){

    $atts = shortcode_atts( 
            array(
                'delay' => '1',
                'capability' => 'read',
                'message' => 'Slow down partner, you don\'t have access to this content yet!'
            ), $atts, 'member_show' );

    if ( function_exists( 'acab_is_user_member' ) )
        if( is_user_member( (int) $atts['delay'] ) && current_user_can( $atts['capability'] ) )
	        return $content;
	elseif( !is_user_member( (int) $atts['delay'] ) && current_user_can( $atts['capability'] ) )
		return $atts['message'];
	     	   
	          
    return 'This content is for members only.';    
	    	     
}
