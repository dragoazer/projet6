<?php
  namespace Projet6\Entity;

	/**
	 * 
	 */
	class GameComment implements \JsonSerializable
	{

		private  $id;
		private  $pseudo;
    private  $comment;
    private  $post_date;
    private  $forumId;
	

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
    public function comment () {return $this->comment;}
    public function post_date () {return $this->post_date;}
    public function forumId () {return $this->forumId;}

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
  			$id = (int) $id;
    		if ($id > 0)
   			{
      			$this->id = $id;
    		}  
    	}

      public function setPseudo($pseudo)
      {
        if (is_string($pseudo))
        {
            $this->pseudo = $pseudo;
        }
      }

      public function setComment($comment)
      {
        if (is_string($comment))
        {
            $this->comment = $comment;
        }
      }

      public function setPost_date ($post_date)
      {
        if (is_string($post_date))
        {
            $this->post_date = $post_date;
        }
      }

      public function setForumId ($forumId)
      {
        $forumId = (int) $forumId;
        if ($forumId > 0)
        {
            $this->forumId = $forumId;
        }  
      }
  }