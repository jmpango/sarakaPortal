<?php
class BuddyImage extends BaseData{
	var $imageName;
	var $imageSmall;
	var $imageMedium;
	var $imageLarge;
	var $imageXLarge;
	var $buddyId;

	public function  __construct(){
		parent::__construct();
	}

	public function setImageName($imageName){
		$this->imageName = $imageName;
	}

	public function getImageName(){
		return $this->imageName;
	}

	public function  setImageSmall($imageSmall){
		$this->imageSmall = $imageSmall;
	}

	public function getImageSmall(){
		return $this->imageSmall;
	}

	public function  setImageMedium($imageMedium){
		$this->imageMedium = $imageMedium;
	}

	public function getImageMeduim(){
		return $this->imageMeduim;
	}

	public function  setImageLarge($imageLarge){
		$this->imageLarge = $imageLarge;
	}

	public function getImageLarge(){
		return $this->imageLarge;
	}

	public function  setImageXLarge($imageXLarge){
		$this->imageXLarge = $imageXLarge;
	}

	public function getImageXLarge(){
		return $this->imageXLarge;
	}

	public function  setBuddyId($buddyId){
		$this->buddyId = $buddyId;
	}

	public function getBuddyId(){
		return $this->buddyId;
	}
}
?>