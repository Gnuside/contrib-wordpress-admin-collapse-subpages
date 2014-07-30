<?php
/*
	Plugin Name: Admin Collapse Subpages
	Plugin URI: http://alexchalupka.com/projects/wordpress/admin-collapse-subpages/
	Description: Using this plugin one can easily collapse/expand pages / custom post types with children and grand children.
	Author: Alex Chalupka
	Author URI: http://alexchalupka.com/
	Version: 2.2
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html

	* This program is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	* GNU General Public License for more details.
*/

if (!class_exists('Admin_Collapse_Subpages')) {

	class Admin_Collapse_Subpages {
		public $version = '2.2';

		function __construct() {
			add_action('admin_enqueue_scripts', array($this, 'acs_scripts'));
		}

		public function acs_admin_body_class( $classes ) {
			$classes .= ' ' .'acs-hier';
			return $classes;
		}

		public function acs_scripts() {
			global $pagenow;

			if(isset($_GET['post_type']) ) {
				$post_type = $_GET['post_type'];
				if(is_post_type_hierarchical($post_type)) {
					add_filter( 'admin_body_class', array($this, 'acs_admin_body_class') );
				}
			}

			if ( is_admin() && isset($_GET['post_type']) && $pagenow =='edit.php' ) {

				//make sure jquery is loaded
				wp_enqueue_script('jquery');

				//cookie script for saving collapse states 
				wp_enqueue_script('jquery-cookie', plugins_url('js/jquery.cookie.js', __FILE__ ), 'jquery', '1.4.0');

				//main collapse pages script
				wp_enqueue_script('acs-js',plugins_url('js/admin_collapse_subpages.js', __FILE__ ), false, $this->version);

				//Load Styles
				wp_enqueue_style('acs-css', plugins_url('css/style.css', __FILE__ ), false, $this->version, 'screen');
			}
		}
	}

	global $collapsePages;
	$collapsePages = new Admin_Collapse_Subpages();
}

?>