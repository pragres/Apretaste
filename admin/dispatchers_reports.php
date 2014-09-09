<?php 

$data['crosstable'] = q("SELECT * FROM dispatchers_recharges_cross;");
$data['recharges_by_day'] = q("SELECT * FROM dispatchers_recharges_by_day ORDER BY dia");
