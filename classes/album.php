<?php

require_once(__DIR__ . "/title.php");

class Album
{
    private $_id;
    private $_name;
    private $_date;
    private $_titles;
    
    function __construct($name, $date, $id = 0)
    {
        $this->_id      = $id;
        $this->_name    = $name;
        $this->_date    = DateTime::createFromFormat("d/m/Y", $date);
        $this->_titles  = array();
    }
    
    public function addTitle($name)
    {
        $this->_titles[] = new Title($this->getId(), $name);
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function getName()
    {
        return $this->_name;
    }
    
    public function getDate()
    {
        return $this->_date;
    }
    
    public function getDateFormatted()
    {
        return $this->_date->format("Y/m/d");
    }
    
    public function getTitles()
    {
        return $this->_titles;
    }
}

?>