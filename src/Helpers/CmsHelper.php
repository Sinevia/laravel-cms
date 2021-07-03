<?php

namespace Sinevia\Cms\Helpers;

class CmsHelper {

    public static function auth($message = '', $data = []) {
        return json_encode(['status' => 'authenticate', 'message' => $message]);
    }

    public static function error($message = '', $data = []) {
        return json_encode(['status' => 'error', 'message' => $message, 'data' => $data]);
    }

    public static function success($message = '', $data = []) {
        return json_encode(['status' => 'success', 'message' => $message, 'data' => $data]);
    }
    
    public static function arrayToHtmlAttributes(array $array) {
        if (count($array) < 1) {
            return '';
        }

        ksort($array);
        $attributes = array();
        foreach ($array as $name => $value) {
            if ($value != "" || $value != null) {
                $attributes[] = $name . '="' . addcslashes($value, '"') . '"';
            }
        }
        return count($attributes) > 0 ? (" " . implode(" ", $attributes)) : "";
    }
    
    /**
     * Lists the files and folders and returns them in a handy array.
     * @access public
     */
    public static function directoryListDirectories($directory, $recurse = false) {
        $directory = rtrim($directory, DIRECTORY_SEPARATOR);
        // 1. An array to hold the files.
        $items = array();
        // 2. Getting a handler to the specified directory
        $handler = opendir($directory);
        // 3. Looping through every content of the directory
        while (false !== ($item = readdir($handler))) {
            // 2.1 Is it this or parent directory?
            if ($item == ".") {
                
            } elseif ($item == "..") {
                
            }
            // 2.2 Is $item a directory? Add and Recurse it!
            elseif (is_dir($directory . DIRECTORY_SEPARATOR . $item)) {
                $items[] = $directory . DIRECTORY_SEPARATOR . $item;
                if ($recurse == true) {
                    $recursed_items = self::directoryListDirectories($directory . DIRECTORY_SEPARATOR . $item, true);
                    $items = array_merge($items, $recursed_items);
                }
            }
        }
        // 4. Closing the handle
        closedir($handler);
        // 5. Returning the file array
        return $items;
    }

}
