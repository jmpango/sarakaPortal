<?php
class BaseController{
	/** Reference to the service object. */
	protected $service;

	/** Refence to a controller. */
	protected $controller;

	/** Reference to an action to be formed. */
	protected $action;

	/** Reference to a view to be returned. */
	protected $view;

	/** Reference to  the view name. */
	protected $baseViewName;

	public function  __construct($baseViewName, $action){
		$this->controller = ucwords(__CLASS__);
		$this->action = $action;
		$this->$baseViewName = $baseViewName;
		$this->view = new View(HOME . DS . 'views' . DS . strtolower($this->$baseViewName) . DS . $action . '.tpl');
	}

	protected function setService($serviceName){
		$serviceName .= 'Service';
		if(class_exists($serviceName)){
			$this->service = new $serviceName();
		}
	}

	protected function setView($viewName){
		$this->view = new View(HOME . DS . 'views' . DS . $viewName . '.tpl');
	}

}
?>