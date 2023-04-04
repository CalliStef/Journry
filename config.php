<?php 
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

// Set error reporting level to ignore warnings
// error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

// Turn off displaying errors (recommended for production)
// ini_set('display_errors', '0');

// Set a reasonable maximum execution time
ini_set('max_execution_time', '30'); // 30 seconds

?>