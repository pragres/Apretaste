<?php

Apretaste::connect();

if (isset($_GET['f'])){
	u("apretaste/admin/view/charts/{$_GET['f']}");
}

// End of file