<?php

namespace WPATDPlugin;

defined('ABSPATH') || die('No script kiddies please!');

class IncludesAssets
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'add_js']);
        add_action('admin_enqueue_scripts', [$this, 'load_stylesheets']);
    }

    public function load_stylesheets()
    {
        $plugin_version = '1.0';

        $css = [
            'plugin_style_ATD' => PLUGIN_URL_ATD . 'assets/style.css',
        ];

        foreach ($css as $handle => $path) {
            wp_enqueue_style($handle, $path, [], $plugin_version);
        }
    }

    public function add_js()
    {
        $plugin_version = '1.0';

        $jss = [
            'plugin_script_ATD' => PLUGIN_URL_ATD . 'assets/script.js',
        ];

        foreach ($jss as $handle => $path) {
            wp_enqueue_script($handle, $path, [], $plugin_version, true);
        }
    }
}
