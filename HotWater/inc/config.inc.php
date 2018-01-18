<?php

define("_TITLE", "GHOSTSERVER");

spl_autoload_register(function ($class) {
    require_once $class . '.class.php';
});

?>