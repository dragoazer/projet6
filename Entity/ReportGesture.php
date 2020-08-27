<?php
  namespace Projet6\Entity;

	/**
	 * 
	 */
	class ReportGesture 
	{
		private  $id;
		private  $topic_id;
		private  $comment_id;
		private  $topic_type;
		private  $report_type ;

    public function __construct (array $data)
    {
      $this->hydrate($data);
    }

		public function id() { return $this->id;}
		public function topic_id() { return $this->topic_id;}
		public function comment_id() { return $this->comment_id;}
		public function topic_type() { return $this->topic_type;}
		public function report_type () { return $this->report_type;}

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
 
    	public function setTopic_id($topic_id)
  		{
    		if (is_string($topic_id) OR is_int($topic_id))
    		{
      			$this->topic_id = $topic_id;
    		}
  		} 
    	public function setComment_id($comment_id)
  		{
    		if (is_string($comment_id) OR is_int($comment_id))
    		{
      			$this->comment_id = $comment_id;
    		} 
  		}

    	public function setTopic_type($topic_type)
  		{
    		if (is_string($topic_type) AND $topic_type === "game")
    		{
      			$this->topic_type = $topic_type;
    		}
  		} 

    	public function setReport_type ($report_type )
  		{
    		if (is_string($report_type) /*AND $report_type == "offensiveInsult" AND $report_type == "fakeNews" AND $report_type == "unsuitableContent"  AND $report_type == "spam"*/)
    		{
      			$this->report_type  = $report_type ;
    		}
  		}

  		    		  			
	}
