<?php

class Title
{
    private $_albumId;
    private $_name;
    
    function __construct($albumId, $name)
    {
        $this->_albumId = $albumId;
        $this->_name    = $name;
    }
    
    public function getAlbumId()
    {
        return $this->_albumId;
    }
    
    public function getName()
    {
        return $this->_name;
    }
}

?>
