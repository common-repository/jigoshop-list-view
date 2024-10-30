<?php
/**
 * Plugin Name:         Jigoshop List View
 * Plugin URI:          http://www.chriscct7.com
 * Description:         This plugin allows users to toggle between list and grid view for products in Jigoshop
 * Author:              Chris Christoff
 * Author URI:          http://www.chriscct7.com
 *
 * Contributors:        chriscct7
 *
 * Version:             4.0
 * Requires at least:   3.5.0
 * Tested up to:        3.6 Beta 3
 *
 * Text Domain:         jlv
 * Domain Path:         /languages/
 *
 * @category            Plugin
 * @copyright           Copyright © 2013 Chris Christoff
 * @author              Chris Christoff
 * @package             JLV
 */

if ( in_array( 'jigoshop/jigoshop.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	load_plugin_textdomain('jlv', false, dirname( plugin_basename( __FILE__ ) ) . '/');
	if (!class_exists('JS_List')) {
		class JS_List {
			public function __construct() { 
  				add_action( 'wp' , array(&$this, 'setup_gridlist' ) , 20);
			}
			function setup_gridlist() {
				add_action( 'get_header', array(&$this, 'setup_scripts_styles'), 20);
				add_action( 'jigoshop_before_shop_loop', array(&$this, 'gridlist_toggle_button'), 20);
				add_action( 'jigoshop_after_shop_loop_item', array(&$this,'jigoshop_template_single_excerpt'), 11);
				add_action( 'jigoshop_after_shop_loop_item', array(&$this, 'gridlist_buttonwrap_close'), 7);
				add_action( 'jigoshop_after_shop_loop_item', array(&$this, 'gridlist_hr'), 30);
			}

			function jigoshop_template_single_excerpt( $post  ) {
			echo '<br>';
			if ($post->post_excerpt){
			$string=apply_filters( 'jigoshop_single_product_excerpt', (wptexturize($post->post_excerpt)) );
			echo '<p class="normalview hide">';echo $string;echo '</p>';
			}
			}

			// Scripts & styles
			function setup_scripts_styles() {
				if (is_shop() || is_product_category()) {
					wp_enqueue_script( 'cookie', plugins_url( '/assets/js/jquery.cookie.min.js', __FILE__ ), array( 'jquery' ) );
					wp_enqueue_script( 'grid-list-scripts', plugins_url( '/assets/js/jquery.gridlistview.min.js', __FILE__ ), array( 'jquery' ) );
					wp_enqueue_style( 'grid-list-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
				}
			}
			
			// Toggle button
			function gridlist_toggle_button() {
				?>
					<nav id="gridlist-toggle">
						<a href="#" id="grid" class="active" title="<?php _e('Grid view', 'js_list_grid_toggle'); ?>">&#8862; <span><?php _e('Grid view', 'js_list_grid_toggle'); ?></span></a><a href="#" id="list" title="<?php _e('List view', 'js_list_grid_toggle'); ?>">&#8863; <span><?php _e('List view', 'js_list_grid_toggle'); ?></span></a>
					</nav>
					<br />
				<?php
			}
			
			function gridlist_buttonwrap_close() {
				?>
					<br class="test">
				<?php
			}
			
			function gridlist_hr() {
				?>
					<hr />
				<?php
			}
		}		
		$JS_List = new JS_List();
	}
}