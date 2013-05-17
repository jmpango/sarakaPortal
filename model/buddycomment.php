<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class BuddyComment extends BaseData{
	var $postedDate;
	var $comment;
	var $author;
	var $buddyId;

	public function  __construct(){
		parent::__construct();
	}

	public function setComment($comment){
		$this->comment = $comment;
	}

	public function getComment(){
		return $this->comment;
	}

	public function  setAuthour($author){
		$this->author = $author;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function  setPostedDate($postedDate){
		$this->postedDate = $postedDate;
	}

	public function getPostedDate(){
		return $this->postedDate;
	}

	public function  setBuddyId($buddyId){
		$this->buddyId = $buddyId;
	}

	public function getBuddyId(){
		return $this->buddyId;
	}
}
?>