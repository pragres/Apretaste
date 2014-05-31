<?php

/**
 * Apretaste Mailboxes Management
 *
 * @author Administrador
 *        
 */
class ApretasteMailboxes {
	
	/**
	 * Increment new shipment
	 *
	 * @param string $mailbox
	 */
	static function addShipment($mailbox){
		self::createMailbox($mailbox);
		
		Apretaste::query("UPDATE mailboxes SET shipments = shipments + 1, last_shipment_date = now() WHERE mailbox='$mailbox';");
	}
	
	/**
	 * Create mailbox if not exists
	 * @param unknown $mailbox
	 * @return boolean
	 */
	static function createMailbox($mailbox){
		$r = Apretaste::query("SELECT * FROM mailboxes WHERE mailbox = '$mailbox';");
		
		if (isset($r[0]))
			if ($r[0]['mailbox'] == $mailbox)
				return true;
		
		Apretaste::query("INSERT INTO mailboxes (mailbox) VALUES ('$mailbox');");
	}
	
	/**
	 * Save last mailbox error
	 *
	 * @param string $mailbox
	 * @param string $error
	 */
	static function saveShipmentError($mailbox, $error = ''){
		self::createMailbox($mailbox);
		
		Apretaste::query("UPDATE mailboxes SET = last_error_date = now(), last_error='$error' WHERE mailbox='$mailbox';");
	}
	
	/**
	 * Return the best candidate
	 *
	 * @param string $to
	 */
	static function getBestMailbox($to = null, $default = null){
		$sql = "select mailbox from mailboxes ";
		
		if (! is_null($to))
			$sql .= " where not exists(select * from mailboxes_restrictions 
			where match_email(mailboxes.mailbox,from_pattern) = true
			and match_email('$to',to_pattern))";
		
		$sql .= "order by shipments, last_shipment_date limit 1;";
		
		$r = Apretaste::query($sql);
		
		if (isset($r[0]))
			return $r[0]['mailbox'];
		
		return $default;
	}
	
	/**
	 * Return total of mailboxes
	 *
	 * @return number
	 */
	static function getMailboxesCount(){
		$r = Apretaste::query("SELECT count(*) as total FROM mailboxes;");
		
		return $r[0]['total'] * 1;
	}
	
	/**
	 * Delete a mailbox record
	 *
	 * @param string $mailbox
	 */
	static function deleteMailBox($mailbox){
		Apretaste::query("DELETE from mailboxes WHERE mailbox='$mailbox';");
	}
	static function getMailBoxes(){
		return Apretaste::query("SELECT * FROM mailboxes;");
	}
	static function addRestriction($from, $to){
		Apretaste::query("Insert into mailboxes_restrictions (from_pattern,to_pattern) values('$from','$to');");
	}
	static function getRestrictions(){
		return Apretaste::query("select * from mailboxes_restrictions;");
	}
	static function deleteRestriction($id){
		Apretaste::query("DELETE from mailboxes_restrictions where id=$id;");
	}
}