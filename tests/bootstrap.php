<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author Mateusz
 */
// TODO: check include path
//ini_set('include_path', ini_get('include_path'));

function load($className) {
    $path = __DIR__ . '/../cgi/' . $className . '.php';
    if (file_exists($path)) {
        require $path;
    }
}
 
spl_autoload_register('load');
?>
