<?php

spl_autoload_register(function ($class) {
    require "./classes/{$class}.php";
});

if (!isset($_SESSION)) {
    session_start();
}
