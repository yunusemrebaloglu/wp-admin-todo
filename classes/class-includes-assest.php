<?php

namespace Plugin_ATD;


defined('ABSPATH') or die('No script kiddies please!');

class IncludesAssest
{

    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'add_js']);
        add_action('admin_enqueue_scripts', [$this, 'load_stylesheets']);
       
    }

    public function load_stylesheets()
    {
        $css = [
            plugin_dir_url('/') . 'admin-todo/assest/style.css'
        ];

        foreach ($css as $key =>  $path) {
            $key = 'plugin_style' . $key;
            wp_register_style($key,  $path, array(), time());
            wp_enqueue_style($key);
        }
    }


    public function add_js()
    {
        $jss = [
            plugin_dir_url('/') . 'admin-todo/assest/script.js'
        ];
    

        foreach ($jss as $key =>  $path) {
            $key = 'plugin_script_ATD' . $key;
            (wp_register_script($key, $path, array(), time(), 1, 1));
            wp_enqueue_script($key);
        }
    }
}
