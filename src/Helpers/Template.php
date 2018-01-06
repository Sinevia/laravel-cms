<?php

// ========================================================================= //
// SINEVIA CONFIDENTIAL                                  http://sinevia.com  //
// ------------------------------------------------------------------------- //
// COPYRIGHT (c) 2008-2017 Sinevia Ltd                   All rights reserved //
// ------------------------------------------------------------------------- //
// LICENCE: All information contained herein is, and remains, property of    //
// Sinevia Ltd at all times.  Any intellectual and technical concepts        //
// are proprietary to Sinevia Ltd and may be covered by existing patents,    //
// patents in process, and are protected by trade secret or copyright law.   //
// Dissemination or reproduction of this information is strictly forbidden   //
// unless prior written permission is obtained from Sinevia Ltd per domain.  //
//===========================================================================//

namespace Sinevia\Cms\Helpers;

class Template {

    private static $cache_directory = null;

    /**
     * * <code>
     * Template::getCache('key',array(
     *     'post'=>true,
     *     'get'=>true,
     *     'session'=>true,
     *     'expires'=>3600 // Default
     * ));
     * </code>
     * @param string $key
     * @param string $options
     * @return boolean
     */
    public static function getCache($key, $options = array()) {
        if (self::$cache_directory == null) {
            return false;
        }
        $post_listener = (isset($options['post']) == false) ? false : true;
        $get_listener = (isset($options['get']) == false) ? false : true;
        $session_listener = (isset($options['session']) == false) ? false : true;
        $expires = isset($options['expires']) == false ? 0 : $options['expires']; // Default 1 hr
        $uid = '';
        $uid = md5($key);
        if ($post_listener == true) {
            $uid .= md5($_POST);
        }
        if ($get_listener == true) {
            $uid .= md5($_GET);
        }
        if ($session_listener == true) {
            $uid .= md5($_SESSION);
        }

        if (!is_dir(self::$cache_directory) OR ! is_writable(self::$cache_directory)) {
            return false;
        }

        $cache_file_path = self::$cache_directory . DIRECTORY_SEPARATOR . $uid;

        if (file_exists($cache_file_path) == false) {
            return false;
        }

        if (filemtime($cache_file_path) < (time() - $expires)) {
            unlink($cache_file_path);
            return false;
        }

        return file_get_contents($cache_file_path);
    }

    public static function setCacheDirectory($cache_directory) {
        self::$cache_directory = $cache_directory;
    }

    /**
     * <code>
     * Template::setCache('key','content',array(
     *     'post'=>true,
     *     'get'=>true,
     *     'session'=>true,
     *     'expires'=>3600 // Default
     * ));
     * </code>
     * @param string $key
     * @param string $content
     * @param string $options
     * @return boolean
     */
    public static function setCache($key, $content, $options = array()) {
        if (self::$cache_directory == null) {
            return false;
        }
        $post_listener = (isset($options['post']) == false) ? false : true;
        $get_listener = (isset($options['get']) == false) ? false : true;
        $session_listener = (isset($options['session']) == false) ? false : true;
        $expires = isset($options['expires']) == false ? 3600 : $options['expires']; // Default 1 hr

        $uid = '';
        $uid = md5($key);
        if ($post_listener == true) {
            $uid .= md5($_POST);
        }
        if ($get_listener == true) {
            $uid .= md5($_GET);
        }
        if ($session_listener == true) {
            $uid .= md5($_SESSION);
        }

        if (!is_dir(self::$cache_directory) OR ! is_writable(self::$cache_directory)) {
            return false;
        }

        $cache_file_path = self::$cache_directory . DIRECTORY_SEPARATOR . $uid;

        $result = file_put_contents($cache_file_path, $content);
        if ($result !== false) {
            touch($cache_file_path, time() + $expires);
        }
        return $result;
    }

    /**
     * This is a simple PHP function to binds a template file with inserted
     * delimited tags with an array with variables to produce an HTML page.
     * @param string $template_file the template file to be binded
     * @param string $entries the entries for the template
     * @param string $options optional delimited tags
     * @return string
     */
    public static function fromFile($template_file, $entries = array()) {
        if (file_exists($template_file) == false) {
            echo '<h3>Required template "' . $template_file . '" DOES NOT exist!</h3>';
            exit;
        }

        $templateContents = file_get_contents($template_file);
        return self::fromString($templateContents, $entries);
    }

    /**
     * This is a simple PHP function to binds a template file with inserted
     * delimited tags with an array with variables to produce an HTML page.
     * @param string $template_file the template file to be binded
     * @param string $entries the entries for the template
     * @param string $options optional delimited tags
     * @return string
     */
    public static function fromString($template_string, $entries = array()) {
        //GUID: 284b3fc8e7fd4616a1bc72003d61156f

        $start_delimiter_72003d61156f = (isset($options['start_tag']) == false) ? '<php>' : $options['start_tag'];
        $end_delimiter_72003d61156f = (isset($options['start_tag']) == false) ? '</php>' : $options['end_tag'];
        $minify_html_72003d61156f = (isset($options['minify_html']) == false) ? true : $options['minify_html'];
        $minify_css_72003d61156f = (isset($options['minify_css']) == false) ? true : $options['minify_css'];
        $minify_js_72003d61156f = (isset($options['minify_js']) == false) ? true : $options['minify_js'];
        $debug_72003d61156f = (isset($options['debug']) == false) ? false : $options['debug'];

        $templateContent_72003d61156f = $template_string;

        // START: Flattened entries
        $flattened_entries = self::flattenArray($entries);
        $_ENV['bind'] = $entries;

        //if ($debug === true) { print_r($flattened_entries); }
        //$entries = array_merge($entries,$flattened_entries);
        $defined_constants = get_defined_constants(true);
        $user_constants = $defined_constants['user'];
        foreach ($user_constants as $key => $value) {
            $templateContent_72003d61156f = str_replace('{' . $key . '}', '<?php echo ' . $key . ';?>', $templateContent_72003d61156f);
            $templateContent_72003d61156f = str_replace($start_delimiter_72003d61156f . '' . $key . $end_delimiter_72003d61156f, '<?php echo ' . $key . ';?>', $templateContent_72003d61156f);
        }
        foreach ($flattened_entries as $key => $value) {
            $templateContent_72003d61156f = str_replace('{$' . $key . '}', '<?php echo $' . $key . ';?>', $templateContent_72003d61156f);
            $templateContent_72003d61156f = str_replace($start_delimiter_72003d61156f . '$' . $key . $end_delimiter_72003d61156f, '<?php echo $' . $key . ';?>', $templateContent_72003d61156f);
        }
        // END: Flattened entries

        /*
          $template = str_replace($start_delimiter, '<?php ', $template);
          $template = str_replace($end_delimiter, ' ?>', $template);
         */
        if ($debug_72003d61156f === true) {
            echo '<h1>DEBUG: Result PHP code from your template</h1>';
            echo '<textarea style="width:800px;height:300px;">' . $template . '</textarea>';
            echo '<hr>';
        }


        extract($entries);           // Make entries first class citizens
        extract($flattened_entries); // Make flattened entries first class citizens

        if ($debug_72003d61156f === true) {
            echo '<h1>DEBUG: All entries at disposal for your template</h1>';
            echo '<pre>';
            echo var_dump($flattened_entries);
            echo '</pre>';
            echo '<hr>';
        }

        ob_start();
        $templateContent_72003d61156f = "?>" . $templateContent_72003d61156f . "<?php ";
        eval($templateContent_72003d61156f);
        $templateContent_72003d61156f = ob_get_contents();
//        if ($minify_html_72003d61156f === true) {
//            $template = bind_html_minify($template);
//        }
//        if ($minify_css_72003d61156f === true) {
//            $template = preg_replace_callback('/\<style([^>]*)\>([^<]*)\<\/style\>/i', 'bind_css_minify', $template);
//        }
//        if ($minify_js_72003d61156f === true) {
//            $template = preg_replace_callback('/\<script([^>]*)\>([^<]*)\<\/script\>/i', 'bind_js_minify', $template);
//        }
        ob_get_clean();
        return $templateContent_72003d61156f;
    }

    public static function minifyHtml($html) {
        $html = str_replace("\r\n", "\n", trim($html));
        $html = preg_replace("#<!--.*?-->#s", '', $html);       // Remove comments
        // !!! Note. Remove extra space only to allow <span><b>Home</b> <i>World</i></span>
        $html = preg_replace("#>[[:space:]]+<#", '> <', $html); // Remove extra space between end and start tags
        $html = preg_replace("#>[[:space:]]+#", '> ', $html);   // Remove extra space after start tags
        $html = preg_replace("#\n[[:space:]]+<#", ' <', $html); // Remove extra space before end tags
        return trim($html);
    }

    public static function minifyCss($css) {
        $css = $css[0];
        $css = preg_replace('/\/\*.*?\*\//', '', $css); // Remove comments
        $css = str_replace("\n", ' ', $css);            // Remove new lines
        $css = str_replace('; ', ';', $css);
        $css = str_replace(': ', ':', $css);
        $css = str_replace(' {', '{', $css);
        $css = str_replace('{ ', '{', $css);
        $css = str_replace(', ', ',', $css);
        $css = str_replace('} ', '}', $css);
        $css = str_replace(';}', '}', $css);
        $css = preg_replace("/[[:space:]]+/", ' ', $css); // Remove extra white space
        return trim($css);
    }

    /**
     * This is a JavaScript minifying function, but beware it is too agressive
     * you may need to disable it if you have too much strings.
     */
    function bind_js_minify($js) {
        //var_dump($js);
        $js_start = '<script' . $js[1] . '>';
        $js_end = '</script>';
        $js = $js[2];
        $js = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $js); // Remove multiline comments
        $js = preg_replace("/\/\/.*/", "", $js); // Remove single line comments
        $js = str_replace("\n", ' ', $js);       // Remove new lines
        $js = preg_replace("/\}\s+/", '}', $js); // Remove extra white space
        $js = preg_replace("/\s+\}/", '}', $js); // Remove extra white space
        $js = preg_replace("/\{\s+/", '{', $js); // Remove extra white space
        $js = preg_replace("/\s+\{/", '{', $js); // Remove extra white space
        // !!! Note. Too greedy, as often seen in text
        //$js = str_replace('; ', ';', $js);
        //$js = str_replace(': ', ':', $js);
        //$js = str_replace(', ', ',', $js);
        return trim($js_start . $js . $js_end);
    }

    /**
     * Flattens a multidimensional array into a one dimensional with
     * dimensions separated by a delimiter
     * @param array $array
     * @param string $delimiter defaults to _
     * @return array
     */
    private static function flattenArray($array, $delimiter = null) {
        if ($delimiter)
            $delimiter .= '_';

        $items = array();

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $items = array_merge($items, self::flattenArray($value, $delimiter . $key));
            } else {
                $items[$delimiter . $key] = $value;
            }
        }

        return $items;
    }

    public static function includeFile($template_file) {
        if (file_exists($template_file)) {
            echo bind($template_file, $_ENV['bind']);
        }
    }

    public static function requireFile($template_file) {
        if (file_exists($template_file) === false) {
            ob_clean();
            echo '<h3>Required template "' . $template_file . '" DOES NOT exist!</h3>';
            exit;
        }

        echo bind($template_file, $_ENV['bind']);
    }

}
