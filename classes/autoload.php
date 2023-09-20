<?php

namespace WPATDPlugin;

define('PLUGIN_CLASS_DIR_ATD', __DIR__ . '/');

class Autoload_ATD
{

    public function __construct()
    {
        $this->autoload();
    }

    public function autoload($dir = PLUGIN_CLASS_DIR_ATD, $is_child = false)
    {
        $fileNames = array_filter(array_diff(scandir($dir), ["..", "."]), function ($item) use ($dir) {
            return strpos($item, 'class') !== false ||  is_dir($dir  . $item);
        });

        foreach ($fileNames as $name) {
            if (strpos($name, ".php") == false) {
                $this->autoload($dir . $name . '/',   $name);
                continue;
            }
            if ($is_child) {
                require $is_child . '/' . $name;
                $className = "\WPATDPlugin\\" . $is_child . '\\' . str_replace(["Class", "-", ".php"], ["", "", ""], ucwords($name, "-"));
            } else {
                require  $name;
                $className = "\WPATDPlugin\\" . str_replace(["Class", "-", ".php"], ["", "", ""], ucwords($name, "-"));
            }
            new $className();
        }
    }
}
