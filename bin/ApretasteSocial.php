<?php
class ApretasteSocial {
	static public function getFriendsOf($email){
		$email = trim(strtolower($email));
		$r = Apretaste::query("
				select friend2 as friend from friends 
					where friend1 = '$email' and  
					not exists(select * 
					from friends_lock where friends_lock.author = friends.friend1 and
					friends_lock.locked = friends.friend2)
					and 
					not exists(select * 
					from friends_lock where friends_lock.author = friends.friend2 and
					friends_lock.locked = friends.friend1)
				UNION
				select friend1 as friend from friends 
				where friend2 = '$email' and  
					not exists(select * 
					from friends_lock where friends_lock.author = friends.friend2 and
					friends_lock.locked = friends.friend1)
					and 
					not exists(select * 
					from friends_lock where friends_lock.author = friends.friend1 and
					friends_lock.locked = friends.friend2);");
		
		$friends = array();
		if (is_array($r))
			foreach ( $r as $rec )
				$friends[] = $rec['friend'];
		
		return $friends;
	}
}