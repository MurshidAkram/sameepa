<?php

function redirect($page)
{
    // Redirect to the specified page
    header("Location: " . URLROOT . "/" . $page);
    exit();
}