<?php

/*
 * 937 	Afghanistan 3556 	Albania 213 	Algeria 376 	Andorra 2449 	Angola 1264 	Anguilla 1268 	Antigua and Barbuda 54 	Argentina 374 	Armenia 297 	Aruba 6 	Australia 436 	Austria 994 	Azerbaijan 1242 	Bahamas 973 	Bahrain 8801 	Bangladesh 1246 	Barbados 375 	Belarus 324 	Belgium 5016 	Belize 2299 	Benin 1441 	Bermuda 591 	Bolivia 3876 	Bosnia and Herzegovina 2677 	Botswana 55 	Brazil 1284 	British Virgin Islands 673 	Brunei Darussalam 359 	Bulgaria 2267 	Burkina Faso 2577 	Burundi 855 	Cambodia 237 	Cameroon 1 	Canada 2389 	Cape Verde 1345 	Cayman Islands 235 	Chad 56 	Chile 861 	China 573 	Colombia 2693 	Comoros 243 	Congo DR of the 242 	Congo Republic of the 682 	Cook Islands 5068 	Costa Rica 3859 	Croatia 53 	Cuba 357 	Cyprus 420 	Czech Republic 45 	Denmark 253 	Djibouti 1767 	Dominica 18 	Dominican Republic 593 	Ecuador 201 	Egypt 503 	El Salvador 240 	Equatorial Guinea 1 	Estados Unidos 3725 	Estonia 2519 	Ethiopia 298 	Faroe Islands 679 	Fiji 358 	Finland 336 	France 5946 	French Guiana 689 	French Polynesia 241 	Gabonese Republic 220 	Gambia 995 	Georgia 49 	Germany 233 	Ghana 3505 	Gibraltar 3069 	Greece 299 	Greenland 1473 	Grenada 590 	Guadalupe 1 	Guam 502 	Guatemala 5926 	Guyana 509 	Haiti 504 	Honduras 852 	Hong Kong 36 	Hungary 354 	Iceland 91 	India 628 	Indonesia 989 	Iran 9647 	Iraq 3538 	Ireland 97 	Israel 393 	Italy 225 	Ivory Coast 1876 	Jamaica 81 	Japan 9627 	Jordan 7300 	Kazakhstan Beeline 7300 	Kazakhstan K-Cell 2547 	Kenya 82 	Korea, South 965 	Kuwait 996 	Kyrgyzstan 8562 	Laos 371 	Latvia 961 	Lebanon 266 	Lesotho 231 	Liberia 2189 	Libyan Arab Jamahiriya 423 	Liechtenstein 3706 	Lithuania 352 	Luxembourg 8536 	Macau 3897 	Macedonia 2613 	Madagascar 265 	Malawi 601 	Malaysia 960 	Maldives 223 	Mali 356 	Malta 596 	Martinica 222 	Mauritania 230 	Mauritius 262 	Mayotte and Reunion 52 	Mexico 373 	Moldova 377 	Monaco 9769 	Mongolia 3826 	Montenegro 2126 	Morocco 2588 	Mozambique 2648 	Namibia 9779 	Nepal 316 	Netherlands 599 	Netherlands Antilles 642 	New Zealand 505 	Nicaragua 227 	Niger 234 	Nigeria 47 	Norway 9689 	Oman 923 	Pakistan 97 	Palestine 5076 	Panama 6757 	Papua New Guinea 5959 	Paraguay 51 	Peru 63 	Philippines 48 	Poland 3519 	Portugal 1 	Puerto Rico 974 	Qatar 407 	Romania 7 	Russian Federation 7 	Russian Federation GSM 2507 	Rwanda 1869 	Saint Kitts and Nevis 1758 	Saint Lucia 6857 	Samoa 9665 	Saudi Arabia 2217 	Senegal 3816 	Serbia 248 	Seychelles 232 	Sierra Leone 65 	Singapore 4219 	Slovakia 386 	Slovenia 27 	South Africa 34 	Spain 947 	Sri Lanka 2499 	Sudan 5978 	Suriname 2686 	Swaziland 46 	Sweden 41 	Switzerland 9639 	Syria 8869 	Taiwan 9929 	Tajikistan 255 	Tanzania 66 	Thailand 228 	Togo 1868 	Trinidad and Tobago 216 	Tunisia 905 	Turkey 9936 	Turkmenistan 1649 	Turks and Caicos Islands 256 	Uganda 380 	Ukraine 9715 	United Arab Emirates 44 	United Kingdom 1 	United States of America 5989 	Uruguay 998 	Uzbekistan 678 	Vanuatu 584 	Venezuela 84 	Viet Nam 1340 	Virgin Islands 9677 	Yemen 2609 	Zambia 263 	Zimbabwe
 */
function cmd_sms_get_country_code($number){}
function cmd_sms($robot, $from, $argument, $body = '', $images = array()){
	$argument = trim($argument);
	$body = strip_tags($body);
	
	// Get country code
	$parts = ApretasteSMS::splitNumber($argument);
	
	if ($parts === false){
		return array(
				"answer_type" => "sms_wrong_number",
				"number" => $argument,
				"message" => $body				
		);
	}
	
	$code = $parts['code'];
	$number = $parts['number'];
	
	// Split message
	$msg = trim($body);
	
	$parts = ApretasteSMS::chopText($msg);
	
	$tparts = count($parts);
	
	// Get rate
	$discount = ApretasteSMS::getRate($code);
	
	// Verify credit
	$credit = ApretasteMoney::getCreditOf($from);
	
	if ($credit < $discount * $tparts) {
		// no credit
		return array(
				"answer_type" => "sms_wrong_number",
				"credit" => $credit,
				"discount" => $discount * $tparts,
				"smsparts" => $parts
		);
	}
	
	// Send message
	
	foreach ( $parts as $i => $part ) {
		$robot->log("Sending sms part $i - $part to $code - $number");
		ApretasteSMS::send($code, $number, $from, $body, $discount);
	}
	
	$newcredit = ApretasteMoney::getCreditOf($from);
	
	return array(
			"answer_type" => "sms_sended",
			"credit" => $credit,
			"newcredit" => $newcredit,
			"discount" => $discount,
			"smsparts" => $parts,
			"totaldiscount" => $discount * $tparts
	);
}
	
