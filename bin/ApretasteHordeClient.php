<?php

/**
 * Horde client via cURL
 *
 * @author Carlos
 * @version 1.0
 *         
 */
class ApretasteHordeClient {
	
	/* Attributes */
	public $account;
	public $client;
	public $logOutToken;
	public $hordeConfig;
	public $inbox = array();
	
	/**
	 * Constructor
	 *
	 * @param string $account
	 */
	function __construct($account = "nauta"){
		$this->account = $account;
		
		$this->hordeConfig = new ApretasteHordeConfig($account);
		$this->client = curl_init();
		
		curl_setopt($this->client, CURLOPT_HTTPHEADER, array(
				"Cache-Control: max-age=0",
				"Origin: " . $this->hordeConfig->originUrl,
				"User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36",
				"Content-Type: application/x-www-form-urlencoded"
		));
		
		curl_setopt($this->client, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->client, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->client, CURLOPT_COOKIEJAR, '../tmp/' . $this->account . 'cookie');
		curl_setopt($this->client, CURLOPT_COOKIEFILE, '../tmp/' . $this->account . 'cookie');
	}
	
	/**
	 * Login in horde account
	 */
	public function login(){
		curl_setopt($this->client, CURLOPT_URL, $this->hordeConfig->baseUrl . "/login.php");
		curl_setopt($this->client, CURLOPT_POSTFIELDS, "app=&login_post=1&url=&anchor_string=&ie_version=&horde_user=apretaste&horde_pass=3Jd8VfFT&horde_select_view=mobile&new_lang=en_US");
		$response = @curl_exec($this->client);
		
		if ($response === false)
			return false;
		
		$this->logOutToken = substr($response, strpos($response, "horde_logout_token"));
		$this->logOutToken = explode("&", $this->logOutToken);
		$this->logOutToken = $this->logOutToken[0];
		$this->logOutToken = explode("=", $this->logOutToken);
		$this->logOutToken = $this->logOutToken[1];
		
		return true;
	}
	
	/**
	 * Logout from horde account
	 */
	public function logout(){
		curl_setopt($this->client, CURLOPT_URL, $this->hordeConfig->baseUrl . "/login.php?horde_logout_token=" . $this->logOutToken);
		curl_exec($this->client);
		curl_close($this->client);
	}
	
	/**
	 * Delete an email
	 *
	 * @param string $mailFolderSubFix
	 * @param string $mailFolderId
	 * @param string $cacheID
	 * @param string $uid
	 */
	public function deleteMail($mailFolderSubFix, $mailFolderId, $cacheID, $uid){
		curl_setopt($this->client, CURLOPT_URL, $this->hordeConfig->baseUrl . "/services/ajax.php/imp/deleteMessages");
		curl_setopt($this->client, CURLOPT_POSTFIELDS, urldecode("view=" . $mailFolderId . "&cacheid=" . $cacheID . "&slice=&cache=&uid=" . $mailFolderSubFix . $mailFolderId . $uid));
		curl_exec($this->client);
	}
	
	/**
	 * Purge deleted emails
	 * @param string $mailFolderId
	 */
	public function purgeDeletedMails($mailFolderId){
		curl_setopt($this->client, CURLOPT_URL, $this->hordeConfig->baseUrl . "/imp/mailbox-mimp.php?mailbox=" . $mailFolderId . "&p=1&a=e");
		curl_exec($this->client);
	}
	
	/**
	 * Read horde inbox
	 */
	public function getInbox($limit = 10, $savexml = true){
		if ($this->login()) {
			
			curl_setopt($this->client, CURLOPT_URL, $this->hordeConfig->baseUrl . "/services/ajax.php/imp/viewPort");
			curl_setopt($this->client, CURLOPT_POSTFIELDS, "view=SU5CT1g&requestid=1&initial=1&after=&before=5000&slice=");
			$response = curl_exec($this->client);
			$response = str_replace("/*-secure-", "", $response);
			$response = str_replace("*/", "", $response);
			
			$obj = json_decode($response);
			
			$cacheID = $obj->response->ViewPort->cacheid;
			
			if (isset($obj->response->ViewPort->data)) {
				$data = $obj->response->ViewPort->data;
				
				if (is_object($data))
					$data = get_object_vars($data);
				
				$this->inbox = array();
				
				$i = 0;
				if (is_array($data))
					foreach ( $data as $key => $value ) {
						$i ++;
						if ($i > $limit)
							break;
						if (in_array("unseen", $value->flag) && ! in_array("seen", $value->flag)) {
							$uid = $value->uid;
							$size = $value->size;
							$mail = $this->getMail($cacheID, $uid, $size);
							if ($savexml)
								$this->saveMailToXML($mail);
							$this->inbox[] = $mail;
							$this->deleteMail("{7}", "SU5CT1g", $cacheID, $uid);
						}
					}
			}
			
			$this->purgeDeletedMails("SU5CT1g");
			$this->logout();
			return $this->inbox;
		}
		return false;
	}
	/**
	 * Get an email
	 *
	 * @param string $cacheID
	 * @param string $uid
	 * @param integer $size
	 * @return ApretasteHordeEmail
	 */
	public function getMail($cacheID, $uid, $size){
		curl_setopt($this->client, CURLOPT_URL, $this->hordeConfig->baseUrl . "/services/ajax.php/imp/showMessage");
		curl_setopt($this->client, CURLOPT_POSTFIELDS, urldecode("view=SU5CT1g&cacheid=" . $cacheID . "&slice=&cache=&preview=1&uid={7}SU5CT1g" . $uid));
		$response = curl_exec($this->client);
		$response = str_replace("/*-secure-", "", $response);
		$response = str_replace("*/", "", $response);
		
		$obj = json_decode($response);
		
		$fromName = "";
		$toName = "Apretaste!";
		
		$mail = new ApretasteHordeEmail();
		$mail->id = $uid;
		
		$fromName = '';
		$toName = '';
		
		if (isset($obj->response->preview->from[0]->personal))
			$fromName = $obj->response->preview->from[0]->personal;
		
		if (isset($obj->response->preview->to[0]->personal))
			$toName = $obj->response->preview->to[0]->personal;
		
		$mail->from = new ApretasteEmailAddress($obj->response->preview->from[0]->inner, $fromName);
		$mail->to = new ApretasteEmailAddress($obj->response->preview->to[0]->inner, $toName);
		$mail->date = $obj->response->preview->localdate;
		$mail->size = $size;
		$mail->mailedBy = "";
		$mail->signedBy = "";
		$mail->subject = $obj->response->preview->subject;
		$mail->body = $obj->response->preview->msgtext;
		
		return $mail;
	}
	
	/**
	 * Save email to XML
	 * @param ApretasteHordeEmail $mail
	 */
	public function saveMailToXML($mail){
		$xml = new DOMDocument("1.0", "UTF-8");
		$xml->formatOutput = true;
		$root = $xml->createElement("email");
		$from = $xml->createElement("from");
		$to = $xml->createElement("to");
		$date = $xml->createElement("date", $mail->date);
		$size = $xml->createElement("size", $mail->size);
		$mailedBy = $xml->createElement("mailed-by", $mail->mailedBy);
		$signedBy = $xml->createElement("signed-by", $mail->signedBy);
		$subject = $xml->createElement("subject", $mail->subject);
		$body = $xml->createElement("body");
		$body_content = $xml->createCDATASection($mail->body);
		$body->appendChild($body_content);
		
		$fromAddress = $xml->createElement("email", $mail->from->email);
		$fromName = $xml->createElement("name", $mail->from->name);
		$toAddress = $xml->createElement("email", $mail->to->email);
		$toName = $xml->createElement("name", $mail->to->email);
		
		$from->appendChild($fromAddress);
		$from->appendChild($fromName);
		
		$to->appendChild($toAddress);
		$to->appendChild($toName);
		
		$root->appendChild($from);
		$root->appendChild($to);
		$root->appendChild($date);
		$root->appendChild($size);
		$root->appendChild($mailedBy);
		$root->appendChild($signedBy);
		$root->appendChild($subject);
		$root->appendChild($body);
		$xml->appendChild($root);
		
		$xml->save($this->hordeConfig->inboxPath . "/email_" . $mail->id . ".xml");
	}
	
	/**
	 * Send emails
	 */
	public function sendMails(){
		$emailFiles = glob($this->hordeConfig->outBoxPath . "/*.xml");
		
		if (count($emailFiles) > 0) {
			
			$this->login();
			
			curl_setopt($this->client, CURLOPT_URL, $this->hordeConfig->baseUrl . "/imp/compose-mimp.php");
			
			$xmlDoc = new DOMDocument();
			
			foreach ( $emailFiles as $emailFile ) {
				
				$xmlDoc->load($emailFile);
				
				$fromAddress = $xmlDoc->getElementsByTagName("from")->item(0)->childNodes->item(1)->nodeValue;
				$fromName = $xmlDoc->getElementsByTagName("from")->item(0)->childNodes->item(3)->nodeValue;
				$subject = $xmlDoc->getElementsByTagName("subject")->item(0)->nodeValue;
				$msg = $xmlDoc->getElementsByTagName("body")->item(0)->nodeValue;
				
				curl_setopt($this->client, CURLOPT_POSTFIELDS, urldecode("composeCache=&to=" . $fromAddress . "&cc=&bcc=&subject=" . $subject . "&message=" . $msg . "&a=Send"));
				sleep(rand(1, 5));
				curl_exec($this->client);
				
				$emailName = substr($emailFile, strrpos($emailFile, "/"));
				copy($emailFile, $this->hordeConfig->successPath . $emailName);
				unlink($emailFile);
			}
			
			$this->deleteSentMessages();
			$this->purgeDeletedMails("U2VudA");
			$this->logout();
		}
	}
	
	/**
	 * Delete sent messages
	 */
	public function deleteSentMessages(){
		curl_setopt($this->client, CURLOPT_URL, $this->hordeConfig->baseUrl . "/services/ajax.php/imp/viewPort");
		curl_setopt($this->client, CURLOPT_POSTFIELDS, "view=U2VudA&requestid=2&initial=1&after=&before=5000&slice=");
		$response = curl_exec($this->client);
		$response = str_replace("/*-secure-", "", $response);
		$response = str_replace("*/", "", $response);
		
		$obj = json_decode($response);
		
		$cacheID = $obj->response->ViewPort->cacheid;
		$data = $obj->response->ViewPort->data;
		
		foreach ( $data as $key => $value ) {
			$uid = $value->uid;
			$this->deleteMail("{6}", "U2VudA", $cacheID, $uid);
		}
	}
}