<?php
//load config 
require_once 'config/config.php';
// Load Libraries
// require_once 'libraries/core.php';
spl_autoload_register(function ($class) {
  require_once 'libraries/'. $class . '.php';
});
