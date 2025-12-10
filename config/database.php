<?php

$mysqli = new mysqli(
    $_ENV["DB_HOST"],
    $_ENV["DB_USER"],
    $_ENV["DB_PASS"],
    $_ENV["DB_NAME"]
);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
