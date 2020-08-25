<?php
  namespace Projet6\Entity;

	/**
	 * 
	 */
	class GameForum implements \JsonSerializable
	{

		private  $id;
		private  $dev;
		private  $creation_date;
		private  $name;
		private  $content;
    private  $title;
    private  $editor;
    private  $creation_topic;
    private  $modified;
    private  $reported;
    

    public function __construct (array $data)
    {
      $this->hydrate($data);
    }

    public function jsonSerialize ()
    {
      return get_object_vars($this);
    }

		public function id() { return $this->id;}
		public function dev() { return $this->dev;}
		public function creation_date() { return $this->creation_date;}
		public function name() { return $this->name;}
		public function content() { return $this->content;}
    public function title() { return $this->title;}
    public function editor() { return $this->editor;}
    public function creation_topic() { return $this->creation_topic;}
    public function modified() { return $this->modified;}
    public function reported() { return $this->reported;}

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
    	public function setId($id)
  		{
    		if (is_int($id) OR is_string($id))
    		{
      			$this->id =  $id;
    		}
  		}

      public function setDev($dev)
      {
        if (is_string($dev) AND strlen($dev) < 50)
        {
            $this->dev =  $dev;
        }
      }

      public function setCreation_date($creation_date)
      {
        if (is_string($creation_date))
        {
            $this->creation_date =  $creation_date;
        }
      }

      public function setName($name)
      {
        if (is_string($name) AND strlen($name) < 50)
        {
            $this->name =  $name;
        }
      }

      public function setContent($content)
      {
        if (is_string($content))
        {
            $this->content =  $content;
        }
      }

      public function setTitle($title)
      {
        if (is_string($title) AND strlen($title) < 50)
        {
            $this->title =  $title;
        }
      }

      public function setEditor($editor)
      {
        if (is_string($editor) AND strlen($editor) < 50)
        {
            $this->editor =  $editor;
        }
      }

      public function setCreation_topic($creation_topic)
      {
        if (is_string($creation_topic))
        {
            $this->creation_topic =  $creation_topic;
        }
      } 

      public function setModified($modified)
      {
        if (is_int($modified))
        {
            $this->modified =  $modified;
        }
      }

      public function setReported($reported)
      {
        if (is_int($reported) OR is_string($reported))
        {
            $this->reported =  $reported;
        }
      }    		  				  		  		
	}