<?php
if (isset($_SESSION['user'])) {
	unset($_SESSION['user']);
}
if (isset($_SESSION['menu'])) {
	unset($_SESSION['menu']);
}
header("Location: index.php");