<?php

function debug($arr, $type = null) {

    if ($type == 'p' && $type != null) {
        static $int = 0;
        echo '<pre><b style="background: red;padding: 1px 5px;">' . $int . '</b> ';
        print_r($arr);
        echo '</pre>';
        $int++;
    } else {

        static $int = 0;
        echo '<pre><b style="background: red;padding: 1px 5px;">' . $int . '</b> ';
        var_dump($arr);
        echo '</pre>';
        $int++;
    }
}

function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}