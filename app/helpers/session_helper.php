<?php

session_start();


function flash($name = '', $message = '', $class = 'alert alert-info', $dismissible = false)
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
            $_SESSION[$name . '_dismissible'] = $dismissible;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $dismissible = isset($_SESSION[$name . '_dismissible']) ? $_SESSION[$name . '_dismissible'] : false;

            $dismissBtn = $dismissible ?
                '<button class="dismiss-btn" onclick="this.parentElement.style.display=\'none\'">&times;</button>' :
                '';

            echo '<div class="flash-message ' . $_SESSION[$name . '_class'] . ' ' .
                ($dismissible ? 'dismissible' : '') . '">' .
                $_SESSION[$name] . $dismissBtn .
                '</div>';

            $_SESSION[$name] = '';
            $_SESSION[$name . '_class'] = '';
            $_SESSION[$name . '_dismissible'] = '';
        }
    }
}
