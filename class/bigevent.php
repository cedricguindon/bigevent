<?php  

class bigevent{

	// Propriétées
	public $id;
	public $title;
	public $url;
	public $class;
	public $start;
	public $end;
	public $desc;
	public $owner;


	// magic get and set
	public function __get($name){
		return $this->$name;
	}

	public function __set($name,$value){
		$this->$name = $value;
	}

	// Construceur avec parametre avec les argument pour le sans parametre
	public function __construct($pId = " ",$pTitle = " ",$pUrl = " ",$pClass = " ",$pStart = " ",$pEnd = " ",$pDesc = " ",$pOwner = " "){
		$this->id = $pId;
		$this->title = $pTitle;
		$this->url = $pUrl;
		$this->class = $pClass;
		$this->start = $pStart;
		$this->end = $pEnd;
		$this->desc = $pDesc;
		$this->owner = $pOwner;
	}

	public function __toString(){
		return $this->id . ":" . $this->title . ":" . $this->url . ":" . $this->class . ":" . $this->start . ":" . $this->end . ":" . $this->desc . ":" . $this->owner;
	}

}


?>