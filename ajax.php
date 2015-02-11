<?php

require_once(__DIR__ . "/classes/database.php");
require_once(__DIR__ . "/classes/parser.php");

if (!isset($_POST['command']))
    die();

$commande = htmlspecialchars($_POST['command']);

switch ($commande)
{
    case 'deleteTables':
    {
        $db = Database::getDatabase();
        $db->exec("DROP TABLE `titles`");
        $db->exec("DROP TABLE `albums`");
        echo "SUCCESS";
        break;
    }
    case 'startParse':
    {
        try
        {
            $parser = new Parser();
            $parser->startParsing("joe.txt");
            echo "SUCCESS";
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
        break;
    }
    default:
        die();
}
