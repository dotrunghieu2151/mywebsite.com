<?php
    define("DS",DIRECTORY_SEPARATOR);
    define("ROOT", dirname(__DIR__) . DS);
    define("APP", ROOT . "app" . DS);
    define("CONFIG", ROOT . "config". DS);
    define("CORE", ROOT . "core" . DS);
    define("CONTROLLER", APP . "controller". DS);
    define("VIEW", APP . "view" . DS);
    define("MODEL", APP . "model" . DS);
    define("LIB", APP . "library" . DS);
    define("HELPERS", LIB . "helpers" . DS);
    define("DEFAULT_CONTROLLER", "homeController");
    define("DEFAULT_ACTION", "index");
    define("SITE_TITLE", "My website");
    $modules = [ROOT,CONFIG,CONTROLLER,VIEW,MODEL,CORE,LIB,HELPERS];
    set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));
    spl_autoload_register("spl_autoload");


  