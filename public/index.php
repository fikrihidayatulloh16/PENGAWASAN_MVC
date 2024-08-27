<?php

if(!session_id()) {
    session_start();
}

require_once '../app/init.php';
require_once 'assets/vendor/autoload.php';

$app = new App;