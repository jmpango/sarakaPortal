<?php
class BuddyUsage extends BaseData{
	var $pageHits;
	var $callHits;
	var $urlHits;
	var $emailHits;
	var $commentHits;
	var $rateHits;
	var $submittedDate;
	var $buddy;

	public function __construct(){
		parent::__contruct();
	}

	public function setPageHits($pageHits){
		$this->pageHits = $pageHits;
	}

	public function getPageHits(){
		return $this->pageHits;
	}

	public function setCallHits($callHits){
		$this->callHits = $callHits;
	}

	public function getCallHits(){
		return $this->callHits;
	}

	public function setUrlHits($urlHits){
		$this->urlHits = $urlHits;
	}

	public function getUrlHits(){
		return $this->urlHits;
	}

	public function setEmailHits($emailHits){
		$this->emailHits = $emailHits;
	}

	public function getEmailHits(){
		return $this->emailHits;
	}

	public function setSubmittedDate($submittedDate){
		$this->submittedDate = $submittedDate;
	}

	public function getSubmittedDate(){
		return $this->submittedDate;
	}

	public function setBuddy($buddy){
		$this->buddy = $buddy;
	}

	public function getBuddy(){
		return $this->buddy;
	}

	public function setCommentHits($commentHits){
		$this->commentHits = $commentHits;
	}

	public function getCommentHits(){
		return $this->commentHits;
	}

	public function setRateHits($rateHits){
		$this->rateHits = $rateHits;
	}

	public function getRateHits(){
		return $this->rateHits;
	}
}
?>