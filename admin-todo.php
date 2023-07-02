<?php
/*
Plugin URI: https://github.com/yunusemrebaloglu/wp-admin-todo
License: 		GPLv2 or later
License URI:	http://www.gnu.org/licenses/gpl-2.0.html
Plugin Name: Admin Todo List
Description: Admin-Todo is a WordPress plugin that works within the admin panel. This plugin allows administrators to create a todo list as they navigate through the interface.

When browsing through pages, if the user clicks on "Todo" in the top navigation menu, a modal window will open. In this modal window, you can enter the title, content, and priority values for the task. The link is automatically retrieved from the current page, and the priority determines the order of the todo based on its importance. On the right side of the form, todos associated with that link are displayed.

If a user directly clicks on a link without clicking on "Todo" in the menu, the retrieved todos will be sorted based on priority and displayed.

Admin-Todo is a useful tool for administrators to stay organized. By keeping a todo list, important tasks can be tracked and prioritized without overlooking anything..
Version: 1.0.0
Author: Yubu
Author URI: https://yunusemre.co
Text Domain: admin-todo-list
*/

define('PLUGIN_DIR_ATD', __DIR__ . '/');
define('PLUGIN_URL_ATD', plugins_url(plugin_basename(PLUGIN_DIR_ATD)).'/');

require_once PLUGIN_DIR_ATD."classes/autoload.php";
new Plugin_ATD\Autoload_ATD();