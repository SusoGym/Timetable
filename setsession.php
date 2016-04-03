<?php

    session_start();

    foreach ($_GET as $key => $entry) {

        if($entry == "-remove-")
        {
            unset($_SESSION[$key]);
        }
        else
        {
            $_SESSION[$key] = $entry;
        }

    }

?>