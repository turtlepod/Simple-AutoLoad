<?php
/**
 * Plugin Name: Simple Autoload TEST
 * Plugin URI: http://genbumedia.com/plugins/{SLUG}/
 * Description: {SHORT DESCRIPTION}
 * Version: 1.0.0
 * Author: David Chandra Purnama
 * Author URI: http://shellcreeper.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: {PLUGIN FOLDER NAME}
 * Domain Path: /languages/
 *
 * @author David Chandra Purnama <david@genbumedia.com>
 * @copyright Copyright (c) 2016, Genbu Media
**/

define( 'THIS_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );


add_action( 'init', function() {
	//require_once 'includes/class-other-stuff.php';
	new This\Includes\Other_Stuff();
	new This\Includes\Stuff();
	new Cool\Libs\Other_Framew();
	new Cool\Libs\Some_Lib();
} );



spl_autoload_register( 'my_autoloader' );
function my_autoloader( $class_name ) {

	/* $namespace => search folders. */
	$autoload = array(
		'This\Includes' => array( 'includes' ),
		'Cool\Libs' => 'library',
	);

	foreach ( $autoload as $ns => $dirs ) {

		if ( false !== strpos( $class_name, $ns ) ) {

			$clean_class_name = str_replace( $ns, '', $class_name );
			$clean_class_name =str_replace( '_', '-', $clean_class_name );
			$clean_class_name = wp_unslash( $clean_class_name );

			if ( is_array( $dirs ) ) {
				foreach ( $dirs as $dir ) {
					$file = trailingslashit( THIS_PATH . $dir ) . 'class-' . strtolower( $clean_class_name ) . '.php';
					if ( file_exists( $file ) ) {
						require_once $file;
						return;
					}
				}
				
			}
			else {
				$dir = $dirs;
				$file = trailingslashit( THIS_PATH . $dir ) . 'class-' . strtolower( $clean_class_name ) . '.php';
				if ( file_exists( $file ) ) {
					require_once $file;
					return;
				}
			}
		}
	}
}




















