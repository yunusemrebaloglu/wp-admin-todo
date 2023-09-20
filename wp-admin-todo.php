<?php

/**
 * Plugin Name: WP Admin Todo List
 * Plugin URI: https://github.com/yunusemrebaloglu/wp-admin-todo
 * Description: WP Admin Todo List is a WordPress plugin that provides task management functionality within the admin panel, allowing administrators to create and manage to-do lists as they navigate through the interface.
 * Version: 1.0.0
 * Author: Yubu
 * Author URI: https://yunusemre.co
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-admin-todo-list
 */

// Define plugin directory and URL constants
if (!defined('PLUGIN_DIR_ATD')) {
  define('PLUGIN_DIR_ATD', __DIR__ . '/');
}
if (!defined('PLUGIN_URL_ATD')) {
  define('PLUGIN_URL_ATD', plugins_url(plugin_basename(PLUGIN_DIR_ATD)) . '/');
}

// Autoload classes
require_once PLUGIN_DIR_ATD . "classes/autoload.php";
new WPATDPlugin\Autoload_ATD();
