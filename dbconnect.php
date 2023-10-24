<?php
@ $db = new mysqli('localhost', 'root', '', 'leafybites');

if (mysqli_connect_errno()) {
	$script = '<script>alert("Error: Could not connect to database. Please try again later.")</script>';
	exit;
}
?>