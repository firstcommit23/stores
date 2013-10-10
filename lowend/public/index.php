<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';
// Run the application!
Zend\Mvc\Application::init(require 'config/'.getenv('APPLICATION_ENV').'/application_'.getenv('APPLICATION_CONFIG').'.config.php')->run();
