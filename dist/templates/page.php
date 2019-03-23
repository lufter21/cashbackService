<?php
if(file_exists('pages/'.$content.'.php')) {
	include('pages/'.$content.'.php');
} else {
	include('templates/404.php');
}
?>