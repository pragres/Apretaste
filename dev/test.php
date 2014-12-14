<?php

// put here test code

Apretaste::connect();


$_POST['btnSend'] = true;
$_POST['chkRealSend'] = true;

$_POST['from'] = 'alejandro.hernandez@mcvcomercial.cu';
$r = q("select string_agg(guest, ' ') as guests from(
select guest,moment from invitation q
where q.moment::date >= current_date - 5
/*and not (q.guest ~* '@frcuba.co.cu')*/
and not exists(select  * from messages_authors m where m.author = q.guest)
and not exists(select * from invitation iq where iq.author = 'alejandro.hernandez@mcvcomercial.cu' and iq.guest = q.guest)
group by guest,moment
order by moment desc
limit 15
) w");
$guests = $r[0]['guests'];
$guests = trim($guests);
$_GET['subject'] = "INVITAR $guests";
echo "\n\n".$guests."\n\n";
include "../admin/robot.php";
echo $data ['logs'];
q("delete from users_actions;
delete from friends where friend1 = 'alejandro.hernandez@mcvcomercial.cu'; 
delete from friends where friend2 = 'alejandro.hernandez@mcvcomercial.cu'; ");

