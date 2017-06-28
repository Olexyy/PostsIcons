<?php

/**
 * @package Posts Icons
 */

/*
Plugin Name: Posts Icons
Plugin URI: https://github.com/Olexyy/PostsIcons
Description: Implements icons in posts.
Version: 1.0
Author: Osadchyy Olexyy
Author URI: https://github.com/Olexyy
License: none
Text Domain: posts_icons
*/

// If this is a part of core initialisation.
if ( defined( 'ABSPATH' ) ) {
  define( 'POSTS_ICONS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
  require_once( POSTS_ICONS__PLUGIN_DIR . 'class.posts_icons.php' );
  add_action( 'init', array( 'Posts_Icons', 'init' ) );
  if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    require_once( POSTS_ICONS__PLUGIN_DIR . 'class.posts_icons_admin.php' );
    add_action( 'init', array( 'Posts_Icons_Admin', 'init' ) );
  }
}
// Else make sure we are safe if called directly.
else {
  exit('Hello world!');
}