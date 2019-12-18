<?php
/**
 * Hide Updates plugin for WordPress
 *
 * @package   hide-updates
 * @link      https://github.com/upperdog/hide-updates
 * @author    Upperdog <hello@upperdog.com>
 * @copyright 2018-2019 Upperdog
 * @license   GPLv2 or later
 *
 * Plugin Name:  Hide Updates
 * Description:  This plugin hides update notifications for WordPress core, plugin, and theme updates in WordPress admin for all users except first registered user or specified users.
 * Version:      1.1.5
 * Author:       Upperdog
 * Author URI:   https://upperdog.com
 * Author Email: hello@upperdog.com
 * License:      GPLv2 or later
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class HideUpdates {

	/**
	 * Class construct.
	 */
	function __construct() {
		add_action( 'admin_menu', array( $this, 'hide_updates_submenu_page' ) );
		add_action( 'admin_init', array( $this, 'block_admin_pages' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_styles' ) );
	}

	/**
	 * Check if current user is allowed to see updates.
	 */
	function allow_current_user() {
		$current_user    = wp_get_current_user();
		$default_user_id = 1;

		if ( is_a( get_user_by( 'ID', $default_user_id ), 'WP_User' ) ) {
			$default_user          = get_user_by( 'ID', $default_user_id );
			$default_allowed_users = array( $default_user->data->user_login );
		} else {
			$default_allowed_users = array();
		}

		$allowed_users = apply_filters( 'hide_updates_allowed_users', $default_allowed_users );

		if ( in_array( $current_user->user_login, $allowed_users ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Remove submenu pages for users not allowed to see WordPress updates.
	 */
	function hide_updates_submenu_page() {
		if ( ! $this->allow_current_user() ) {
			remove_submenu_page( 'index.php', 'update-core.php' );
		}
	}

	/**
	 * Block access to certain admin pages for users not allowed to see WordPress updates.
	 */
	function block_admin_pages() {

		if ( ! $this->allow_current_user() ) {
			global $pagenow;

			$blocked_admin_pages = array(
				'update-core.php',
				'plugins.php?plugin_status=upgrade',
			);

			$block_current_page = false;

			foreach ( $blocked_admin_pages as $block_admin_page ) {
				$block_admin_page = explode( '?', $block_admin_page );

				if ( $pagenow == $block_admin_page[0] ) {
					$block_current_page = true;
				}
				
				if ( isset( $block_admin_page[1] ) ) {
					parse_str( $block_admin_page[1], $query_params );
					
					foreach ( $query_params as $key => $value ) {
						if ( isset( $_GET[ $key ] ) && $_GET[ $key ] == $value ) {
							$block_current_page = true;
							break;
						} else {
							$block_current_page = false;
						}
					}
				}
			 	
				if ( $block_current_page ) {
					wp_safe_redirect( admin_url( '/' ) );
					exit;
				}
			}
		}
	}

	/**
	 * Enqueue plugin stylesheet to hide elements for users not allowed to see WordPress updates.
	 */
	function enqueue_plugin_styles() {
		if ( is_user_logged_in() && ! $this->allow_current_user() ) {
			wp_enqueue_style( 'hide_updates_css', plugins_url( 'hide-updates.css', __FILE__ ) );
		}
	}
}

$hide_updates = new HideUpdates();
