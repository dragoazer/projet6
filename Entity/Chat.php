<?php
   namespace Projet6\Entity;

	/**
	 * 
	 */
	class Chat implements \JsonSerializable
	{
		private $id;
		private $pseudo;
		private $message;
		private $time;
		private $date;

		public function __construct (array $data)
    	{
      		$this->hydrate($data);
    	}

    	public function jsonSerialize ()
    	{
      		return get_object_vars($this);
    	}

    	public function id () { return $this->id;}
		public function pseudo () { return $this->pseudo;}
    	public function message () {return $this->message;}
    	public function time () {return $this->time;}
    	public function date () {return $this->date;}

    	public function hydrate(array $data)
    	{
      		foreach ($data as $key => $value) {
        		$method = 'set'.ucfirst($key);           
       	 		if (method_exists($this, $method)) {
        			$this->$method($value);
        		}
      		}
    	}

    	public function setId($id) 
  		{
  			$id = (int) $id;
    		if ($id > 0) {
      			$this->id = $id;
    		}  
    	}

    	public function setPseudo($pseudo)
      	{
        	if (is_string($pseudo)) {
            	$this->pseudo = $pseudo;
        	}
     	}

     	public function setMessage($message)
     	{
     		if(is_string($message) AND strlen($message) < 100 ) {
     			$this->$message = $message;
     		}
     	}

     	public function setTime($time)
     	{
     		if (!isset($time)) {
     			$this->$time = date('H:i');
     		}
     	}

     	public function setDate($date)
     	{
     		if (!isset($date)) {
     			$this->$date = date('Y-m-d');
     		}
     	}
	}