<?php
/**
 * Plugin Name: Hide Updates
 * Description: This plugin hides update notices for core, plugin, and theme updates in WordPress admin for all users **except super admins**. It's useful for agencies or developers who take care of updates and maintenance of a client's site and wants to hide the notices for other users.
 * Version: 1.0
 * Author: Upperdog
 * Author URI: https://upperdog.com
 * Author Email: hello@upperdog.com
 * License: GPLv2 or later

 Copyright 2017 Upperdog (email : hello@upperdog.com)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 2, as 
 published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !function_exists( 'wp_get_current_user' ) ) {
    include( ABSPATH . 'wp-includes/pluggable.php' );
}

class HideUpdates {
	
	function __construct() {
		
		global $hide_updates_current_user;
		$hide_updates_current_user = wp_get_current_user();
		
		global $hide_update_default_user_ids;
		$hide_update_default_user_ids = array( 1 );

		global $blocked_admin_pages;
		$blocked_admin_pages = array( 'update-core.php' );
		
		add_action( 'admin_menu', array( $this, 'hide_updates_submenu_page' ) );
		add_action( 'admin_init', array( $this, 'hide_updates_block_pages') );
		add_action( 'admin_enqueue_scripts', array( $this, 'hide_updates_enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'hide_updates_enqueue_scripts' ) );
	}
	
	/**
	 * Remove submenu pages for users not allowed to see WordPress updates.
	 */
	function hide_updates_submenu_page() {
		
		global $hide_updates_current_user, $hide_update_default_user_ids;
		$hide_updates_allowed_user_ids = apply_filters( 'hide_updates_allowed_user_ids', $hide_update_default_user_ids );
		
		if ( !in_array( $hide_updates_current_user->ID, $hide_updates_allowed_user_ids ) ) {
			remove_submenu_page( 'index.php', 'update-core.php' );
		}
	}
	
	/**
	 * Block access to certain admin pages for users not allowed to see WordPress updates. 
	 */
	function hide_updates_block_pages() {
		
		global $hide_updates_current_user, $hide_update_default_user_ids, $pagenow, $blocked_admin_pages;
		$hide_updates_allowed_user_ids = apply_filters( 'hide_updates_allowed_user_ids', $hide_update_default_user_ids );
		
		if ( !in_array( $hide_updates_current_user->ID, $hide_updates_allowed_user_ids ) ) {
			
			if ( in_array( $pagenow, $blocked_admin_pages ) ) {
				wp_redirect( admin_url( '/' ) );
				exit;
			}
		}
	}
	
	/**
	 * Enqueue plugin stylesheet to hide elements for users not allowed to see WordPress updates.  
	 */
	function hide_updates_enqueue_scripts() {
		
		global $hide_updates_current_user, $hide_update_default_user_ids;
		$hide_updates_allowed_user_ids = apply_filters( 'hide_updates_allowed_user_ids', $hide_update_default_user_ids );
		
		if ( !in_array( $hide_updates_current_user->ID, $hide_updates_allowed_user_ids ) ) {
			wp_enqueue_style( 'hide_updates_css', plugins_url( 'hide-updates.css', __FILE__ ) );
		}
	}
}

$hide_updates = new HideUpdates();