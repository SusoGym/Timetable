<?php namespace timetable;
    session_start();

    require "ChromePhp.php";
    require "view.php";
    require "model.php";
    require "controller.php";

    const DEBUG = true;
    ChromePhp::setEnabled(DEBUG);

    if (DEBUG)
    {
        ini_set("display_errors", true);
        enableCustomErrorHandler();
    }

    setlocale(LC_TIME, "de_DE");
    date_default_timezone_set('Europe/Berlin'); // if not corretly set in php.ini

    $input = array_merge($_GET, $_POST);

    $controller = new Controller();

    $controller->handleInput($input);


    /**
     * This function will throw Exceptions instead of warnings (better to debug)
     */
    function enableCustomErrorHandler()
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline)
        {
            // error was suppressed with the @-operator
            if (0 === error_reporting())
            {
                return false;
            }

            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }


?>
