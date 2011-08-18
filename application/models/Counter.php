<?php

Class Model_Counter
{
	private $_hits;
	private $_mapper;	
	
	
	public function getHits()
	{
		return $this->_hits;
	}
	
	public function loadHits()
	{
		$this->getMapper()->getHits($this);	
	}
	
	public function setHits($NrHits)
	{
		$this->_hits = $NrHits;
	}
	
	public function increment()
	{
		$this->_hits++;
		$this->getMapper()->save($this);
	}
	
	
	public function getMapper()
	{
		if (null === $this->_mapper) 
		{
            $this->setMapper(new Model_Mapper_Counter());
        }
		return $this->_mapper;
	}
	
	
	public function setMapper($mapper)
	{
		$this->_mapper = $mapper;
		return $this;
	}
	
}