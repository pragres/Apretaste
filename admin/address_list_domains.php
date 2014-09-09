<?php
$data['providers'] = Apretaste::query("Select provider, total, case when provider ~* '.cu' then 1 else 0 end as national from (
		SELECT get_email_domain(email) as provider, count(*) as total
		from address_list group by provider order by total desc) as subq limit 500;");