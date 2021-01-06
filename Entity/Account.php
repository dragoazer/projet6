<?php
  namespace Projet6\Entity;

	/**
	 * 
	 */
	class Account 
	{

		private  $id;
		private  $pseudo;
		private  $user_type;
		private  $profile_picture;
		private  $email;
		private  $pwd;

    public function __construct (array $data)
    {
      $this->hydrate($data);
    }

		public function id() { return $this->id;}
		public function pseudo() { return $this->pseudo;}
		public function user_type() { return $this->user_type;}
		public function profile_picture() { return $this->profile_picture;}
		public function email() { return $this->email;}
		public function pwd() { return $this->pwd;}

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
    	public function setUser_type($user_type)
  		{
    		if (is_string($user_type) AND $user_type === "member" OR $user_type === "admin")
    		{
      			$this->user_type = $user_type;
    		}
  		}

    	public function setProfile_picture($profile_picture)
  		{
    		if (is_string($profile_picture))
    		{
      			$this->profile_picture = $profile_picture;
    		}
  		} 

    	public function setEmail($email)
  		{
    		if (is_string($email) AND filter_var($email, FILTER_VALIDATE_EMAIL))
    		{
      			$this->email = $email;
    		}
  		}

    	public function setPwd($pwd)
  		{
    		if (is_string($pwd) AND preg_match("/([a-zA-Z0-9._-]){8}/", $pwd))
    		{
      			$this->pwd =  $pwd;
    		}
  		}    		    		  				  		  		
	}