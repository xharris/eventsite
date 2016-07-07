<?php

function includeHeader() {
    include "header.php";
}

function includeFooter() {
    include "footer.php";
}

function randomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 10; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

function formatDateTime($dt_str) {
    $date = strtotime($dt_str);
    return date('m/d g:ia', $date);
}

?>
