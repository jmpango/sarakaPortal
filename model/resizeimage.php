<?php
class ResizeImage{
	var $image;
	var $imageWidth;
	var $imageHeight;
	
	public function __construct($image){
		$this->image = $image;
		$imageSize = getimagesize($image);
		
		$this->imageWidth = $imageSize[0];
		$this->imageHeight = $imageSize[1];
	}

	public function getSmall(){
		$newWidth = 30;
		$newHeight = 30;
		
		$smallImage = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($smallImage, imagecreatefromstring(file_get_contents($this->image)), 0, 0, 0, 0, $newWidth, $newHeight, $this->imageWidth, $this->imageHeight);
		return $smallImage;
	}

	public function getMeduim(){

	}

	public function getLarge(){

	}

	public function getXLarge(){
		return $this->image;
	}
}
?>