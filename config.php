<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'studyApp');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

function h($str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}