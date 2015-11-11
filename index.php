<?php
/*
Plugin Name: Show before post if TRUE
Description: Show content before a post when the post-number in the loop matches a condition
Author:      Andreas Heigl
Author URI:  http://andreas.heigl.org
Plugin URI:  https://github.com/heiglandreas/showafterpostiftrue
License:     MIT
License URI: http://openlicenses.org/mit
Version:     1.0.0
Text Domain: sapif
Domain Path: /language
 */

require_once 'Sapif.php';
require_once 'SapifSettings.php';
require_once 'lib/AdvancedFunctions.php';
require_once 'lib/Graph.php';
require_once 'lib/Math.php';
require_once 'lib/Matrix.php';
require_once 'lib/Parser.php';
require_once 'lib/Stack.php';
require_once 'lib/Trig.php';

$myClass = new \Org_Heigl\Wordpress\Sapif();

add_action('the_post', [$myClass, 'addContent'], 10, 2);

if (is_admin()) {
    $settings_page = new \Org_Heigl\Wordpress\SapifSettings();
    add_action('admin_menu', [$settings_page, 'add_plugin_page']);
    add_action('admin_init', [$settings_page, 'page_init']);

}
