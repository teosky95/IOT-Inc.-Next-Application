<?php
session_start();
$connection = mysqli_connect('localhost', 'root', '1234', 'iot inc next');
session_write_close();
?>