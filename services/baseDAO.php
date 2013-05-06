<?php
class BaseDAO{
	protected $db;
	public $maxLimit = 10;
	public $offset = 0;
	public $totalCount;
	public  function  __construct(){
		$this->db = Db::init();
	}
	public function setOffSet($offSet)
	{
		$this->offset = $offSet;
	}
	
	public function setTotalCount($totalCount){
		$this->totalCount=$totalCount;
	}
}
?>