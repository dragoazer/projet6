<?php
    namespace Projet6\Entity;

  /**
   * 
   */
  class Chatting implements \JsonSerializable
  {

    private $id;
    private $pseudo;
    private $message;
    private $chat_time;
    private $chat_date;

    public function __construct (array $data)
    {
      $this->hydrate($data);
    }

    public function jsonSerialize ()
    {
      return get_object_vars($this);
    }

    public function id() { return $this->id;}
    public function pseudo () { return $this->pseudo;}
    public function message () { return $this->message;}
    public function chat_time () { return $this->time;}
    public function chat_date () { return $this->date;}

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

      public function setPseudo($pseudo)
        {
          if (is_string($pseudo)) {
              $this->pseudo = $pseudo;
          }
      }

      public function setMessage($message)
      {
        if (is_string($message) AND strlen($message) < 50) {
          $this->message = $message;
        }
      }

      public function setChat_time($chat_time)
      {
        if (is_string($chat_time) AND strlen($chat_time) > 0) {
          $this->chat_time = $chat_time;
        } else {
          date_default_timezone_set('Europe/Paris');
          $this->chat_time = date("H-i");
        }
      }

      public function setChat_date($chat_date)
      {
        if (is_string($chat_date) AND  strlen($chat_date) > 0) {
          $this->chat_date = $chat_date;
        } 
      }                          
  }