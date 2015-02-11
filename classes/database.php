<?php

require_once(__DIR__ . "/../includes/config.php");

class Database
{
    static private $_database = null;
    
    static public function getDatabase()
    {
        if (self::$_database == null)
            self::initConnection();

        return self::$_database;
    }
    
    static private function initConnection()
    {
        global $db_host;
        global $db_port;
        global $db_username;
        global $db_password;
        global $db_name;

        try
        {
            self::$_database = new PDO('mysql:host=' . $db_host . ';port=' . $db_port . ';dbname=' . $db_name . ';charset=utf8', $db_username, $db_password);
        }
        catch (Exception $e)
        {
            throw new Exception("Une erreur s'est produite lors de la connexion � la base de donn�e.");
        }
    }
}

?>