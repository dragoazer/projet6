<?php
  namespace Projet6\Entity;

	/**
	 * 
	 */
	class GameForum 
	{

		private  $id;
		private  $dev;
		private  $date;
		private  $name;
		private  $content;

    public function __construct (array $data)
    {
      $this->hydrate($data);
    }

		public function id() { return $this->id;}
		public function dev() { return $this->dev;}
		public function date() { return $this->date;}
		public function name() { return $this->name;}
		public function content() { return $this->content;}
    public function title() { return $this->title;}

    public function hydrate(array $data)
    {
      foreach ($data as $key => $value)
      {
        $method = 'set'.ucfirst($key);           
        if (method_exists($this, $method))
        {
          $this->$method($value);
        }
      }
    }
    	public function id($id)
  		{
    		if (is_string($id))
    		{
      			$this->id =  $id;
    		}
  		}

      public function dev($dev)
      {
        if (is_string($dev))
        {
            $this->dev =  $dev;
        }
      }

      public function date($date)
      {
        if (is_string($date))
        {
            $this->date =  $date;
        }
      }

      public function name($name)
      {
        if (is_string($name))
        {
            $this->name =  $name;
        }
      }

      public function content($content)
      {
        if (is_string($content))
        {
            $this->content =  $content;
        }
      }

      public function title($title)
      {
        if (is_string($title))
        {
            $this->title =  $title;
        }
      }   		    		  				  		  		
	}