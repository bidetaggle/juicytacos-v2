<?php

namespace Lib;

use Exception;

class Configuration
{
    /**
     * Path to the global parameters file
     */
    const PARAMETERS_PATH = "../parameters.json";

    /**
     * Is https enabled, boolean value
     */
    public static $debug;

    /**
     * Is https enabled, boolean value
     */
    public static $httpsEnabled;

    /**
     * Root url of website
     */
    public static $rootURL;

    /**
     * Root path of website
     */
    public static $rootPath;

    /**
     * Current working directory
     * @var string
     */
    public static $currentDir;

    /**
     * Database host
     * @var string
     */
    public static $databaseHost;

    /**
     * Database port
     * @var int
     */
    public static $databasePort;

    /**
     * Database name
     * @var string
     */
    public static $databaseName;

    /**
     * Database user
     * @var string
     */
    public static $databaseUser;

    /**
     * Database password
     * @var string
     */
    public static $databasePassword;

    /**
     * Database table prefix
     * @var string
     */
    public static $databaseTablePrefix;

    /**
     * 
     * @var string
     */
    public static $salt;

    /**
     * Mail de KWAM
     * @var string
     */
    public static $mailKWAM;

    /**
     * Nom du site
     * @var string
     */
    public static $websiteName;

    /**
     * Nom du site
     * @var string
     */
    public static $mailOwner;

    /**
     * Initialize parameters
     */
    public static function initialize()
    {
        // Set the current working directory
        self::$currentDir = getcwd();

        // // Get the parameters
        // $parameters = json_decode(file_get_contents(sprintf(
        //     "%s/%s",
        //     __DIR__,
        //     self::PARAMETERS_PATH
        // )), true);

        require_once("parameters.php");

        $parameters = json_decode($params, true);

        // Required parameters
        $requiredParameters = array(
            "debug",
            "httpsEnabled",
            "rootURL",
            "rootPath",
            "databaseHost",
            "databasePort",
            "databaseName",
            "databaseUser",
            "databasePassword",
            "databaseTablePrefix",
            "salt",
            "mailKWAM",
            "websiteName",
            "mailOwner"
        );

        // Set parameters
        foreach ($requiredParameters as $requiredParameter)
        {
            if (!isset($parameters[$requiredParameter]))
            {
                throw new Exception("Parameter $requiredParameter required");
            }

            self::$$requiredParameter = $parameters[$requiredParameter];
        }
        if(self::$httpsEnabled == true)
            self::$rootURL = "https://".self::$rootURL;
        else
            self::$rootURL = "http://".self::$rootURL;
    }

    public static function getDSN()
    {
        return sprintf(
            "mysql:host=%s;port=%d;dbname=%s",
            self::$databaseHost,
            self::$databasePort,
            self::$databaseName
        );
    }
}