<?php

$conn = mysqli_connect("localhost", "Admin", "Admin", "login");

if (!$conn) {
    echo "Connection Failed";
}