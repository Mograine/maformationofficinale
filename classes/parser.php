<?php

require_once(__DIR__ . "/album.php");
require_once(__DIR__ . "/database.php");

class Parser
{
    private $_database;
    private $_fileText;
    private $_albums;

    public function startParsing($fileName)
    {
        $this->_database = Database::getDatabase();
        
        $this->initDatabaseIfNeeded();
        $this->getTextFromFile($fileName);
        $this->cleanText();

        $albumStringsArray = $this->separateEachAlbum();
        $this->hydrateAlbums($albumStringsArray);
        $this->saveAlbumsToDB();
    }

    /*
     * Check database existence from information_schema, create them if needed
     */
    private function initDatabaseIfNeeded()
    {
        global $db_name;

        $verificationRequest = $this->_database->prepare("SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME IN ('album', 'titres')");
        $verificationRequest->execute(array($db_name));
        
        if ($verificationRequest->fetchColumn() >= 2)
            return;
        
        $this->_database->exec("CREATE TABLE IF NOT EXISTS albums( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, `date` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=INNODB; ");
        $this->_database->exec("CREATE TABLE IF NOT EXISTS titles( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `album_id` INT UNSIGNED NOT NULL, `name` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`), CONSTRAINT `FK_Album` FOREIGN KEY (`album_id`) REFERENCES `albums`(`id`) ) ENGINE=INNODB; ");
    }

    private function getTextFromFile($fileName)
    {
        try
        {
            $this->_fileText = file_get_contents($fileName);
        }
        catch (Exception $e)
        {
            throw new Exception("Une erreur s'est produite lors de la récupération du fichier texte.");
        }
    }
    
    /*
     * Clean $this->_fileText from extra spaces and new lines
     */
    private function cleanText()
    {
        $this->_fileText = preg_replace("/[\r\n]{3,}/",         "\n\n",         $this->_fileText);
        $this->_fileText = preg_replace("/[\r\n]{2,}Sorti le/", "\nSorti le",   $this->_fileText);
        $this->_fileText = preg_replace("/([\r\n]) +/",         "$1",           $this->_fileText);
    }
    
    /*
     * Use Regex to separate each album in one array
     */
    private function separateEachAlbum()
    {
        preg_match_all("#(\n.+\nSorti le:.+(?:\n.+)+\n)#", $this->_fileText, $matches);
        return $matches[0];
    }
    
    /*
     * Fill $this->_albums with new Album hydrated from $albumStringsArray data
     */
    private function hydrateAlbums($albumStringsArray)
    {
        $this->_albums = array();
        
        foreach ($albumStringsArray as $albumStrings)
        {
            $strings = explode("\n", $albumStrings);
            
            $name = $strings[1];
            $date = substr($strings[2], 10, 10);
            
            $album = new Album($name, $date);
            
            for ($i = 3; $i < count($strings) - 1; ++$i)
                $album->addTitle($strings[$i]);
            
            $this->_albums[] = $album;
        }
    }
    
    private function saveAlbumsToDB()
    {
        $this->_database->beginTransaction();
        
        $albumInsertRequest = $this->_database->prepare("INSERT INTO albums (id, name, date) VALUES (0, ?, ?);");
        $titleInsertRequest = $this->_database->prepare("INSERT INTO titles (id, album_id, name) VALUES (0, ?, ?);");

        foreach ($this->_albums as $album)
        {
            $albumInsertRequest->execute(array($album->getName(), $album->getDateFormatted()));
            $albumId = $this->_database->lastInsertId();

            foreach ($album->getTitles() as $title)
                $titleInsertRequest->execute(array($albumId, $title->getName()));
        }

        $this->_database->commit();
    }
}

?>