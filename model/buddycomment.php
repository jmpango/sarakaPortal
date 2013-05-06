<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class BuddyComment extends BaseData{
	var $comment;
	var $author;
	
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
}
?>