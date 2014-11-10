
CREATE OR REPLACE FUNCTION tg_before_confirm_purchase()
  RETURNS trigger AS
$BODY$
declare r record;

begin
	if OLD.bought = TRUE THEN
		raise exception '{error_level: "fatal", err_code: 3, err_msg: "Purchase already confirmed", purchase: "%"}', OLD.id;
		Rollback transaction;
	end if;

	if OLD.moment + '1 hour'::interval < now() then

		-- delete the purchase (async)
		insert into query_queue (query, start_time) 
		values ('DELETE FROM store_purchase WHERE id = ' || quote_literal(OLD.id) || ';', 
			now() + '1 minutes'::interval);
			
		raise exception '{error_level: "fatal", err_code: 4, err_msg: "Purchase out of date", purchase: "%"}', OLD.id;
		Rollback transaction;
	end if;

	return NEW;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;