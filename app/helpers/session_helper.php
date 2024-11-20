<?php

session_start();


function flash($name = '', $message = '', $class = 'alert alert-info', $ignore = false)
{
    if (!empty($name)) {
        // If the ignore flag is set, just return the existing message without modifying the session
        if ($ignore && !empty($_SESSION[$name])) {
            return;
        }

        // If there's a message, store it in session
        if (!empty($message) && empty($_SESSION[$name])) {
            // Set message
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            // If no message provided, check if it's stored in session and display it
            echo '<div class="' . $_SESSION[$name . '_class'] . '">' . $_SESSION[$name] . '</div>';
            // "Ignore" the message, meaning do not remove it after displaying
            $_SESSION[$name] = '';  // Clearing message, but keeping session variable for future use
            $_SESSION[$name . '_class'] = '';  // Clearing the message class
        }
    }
}
