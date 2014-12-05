<?php


$fname = get('fname');

$log = file_get_contents("../logs/$fname.log");

echo '<pre style="background:black;color:white;">'.$log.'</pre>';

return true;