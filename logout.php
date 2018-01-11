<?php

require_once 'base/first.php';

$user = new User();
$user->logout();

Redirect::to('index.php');