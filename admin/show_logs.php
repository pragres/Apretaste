<?php


$fname = get('fname');

$log = file_get_contents("../log/$fname.log");

echo '<pre style="background:black;color:white;">'.$log.'</pre>';

return true;