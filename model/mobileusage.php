<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class MobileUsage extends BaseData{
	var $pageHit;
	var $callHit;
	var $urlHit;
	var $emailHit;
	var $buddyId;

	public function __construct() {
		parent::__construct();
	}

	public function setPageHit($pageHit){
		$this->pageHit = $pageHit;
	}

	public function getPageHit(){
		return $this->pageHit;
	}

	public function setCallHit($callHit){
		$this->callHit = $callHit;
	}

	public function getCallHit(){
		return $this->callHit;
	}

	public function setUrlHit($urlHit){
		$this->urlHit = $urlHit;
	}

	public function getUrlHit(){
		return $this->urlHit;
	}

	public function setEmailHit($emailHit){
		$this->emailHit = $emailHit;
	}

	public function getEmailHit(){
		return $this->emailHit;
	}

	public function setBuddyId($buddyId){
		$this->buddyId = $buddyId;
	}

	public function getBuddyId(){
		return $this->buddyId;
	}
}
?>