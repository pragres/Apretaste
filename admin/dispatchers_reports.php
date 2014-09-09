<?php 

$data['crosstable'] = q("SELECT dispatcher, \"3\", \"5\", \"10\", total FROM dispatchers_recharges_cross;");
$data['recharges_by_day'] = q("SELECT dia as day, total as recharges, amount FROM dispatchers_recharges_by_day ORDER BY dia");
