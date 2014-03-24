<?php
if ($_GET['service'] == 'weather')
	echo file_get_contents('http://free.worldweatheronline.com/feed/weather.ashx?q=' . $_GET['city'] . '&key=93fvz526zx8uu26b59cpy9xf&format=json&no_of_days=2&includeLocation=yes');
