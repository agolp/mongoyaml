<?php

/**
 * MongoYaml is a simple import/export tool to interact with MongoDB
 * by using the Yaml format.
 *
 * This is a simple extension to the sfYaml package written by
 * Fabien Potencier for the symfony framework.
 *
 * This class has *NOT* been thoroughly tested. Use it at your own risk!
 */

require_once 'vendor/sfYaml/lib/sfYaml.php';

class MongoYaml
{
    const OBJECT_STRING = '!!php/object:';
    protected $database;

    /**
     * Constructor
     *
     * @param MongoDB   $database
     */
    public function __construct(MongoDB $database)
    {
        $this->database = $database;
    }


    /**
     * Dumps a collection to a YAML file.
     *
     * By convention, each collection is dumped to its own YAML file,
     * named collection.yml. Any existing file with this name will be crushed
     * without notice.
     *
     * @param  string    $collection   The collection name
     * @param  integer   $inline       The level where you switch to inline YAML
     * @return MongoYaml 
     */
    public function dump($collection, $inline = 10)
    {
        $data = iterator_to_array($this->database->$collection->find());
        $yaml = sfYaml::dump(array($collection => $data), $inline);
        file_put_contents($collection . '.yml', $yaml);
        return $this;
    }

    
    /**
     * Loads a YAML file and imports its content in Mongo
     *
     * This method does not truncate collections before importing data.
     * @param  string    $path          The YAML file path
     * @return MongoYaml
     */
    public function load($path)
    {
        $values = sfYaml::load($path);
        foreach($values as $collection => $array)
        {
            foreach($array as $data)
            {
                $this->database->$collection->save($data);
            }
        }
        return $this;
    }

    /**
     * Helper method to create an ObjecId() in a YAML file
     *
     * @param  string   $id
     */
    public static function Id($id = null)
    {
        echo self::OBJECT_STRING, serialize(new MongoId($id)), "\n";
    }

    /**
     * Helper method to create a MondoDate() in a YAML file
     *
     * @param  integer  $sec
     * @param  integer  $usec
     */
    public static function Date($sec = null, $usec = null)
    {
        echo self::OBJECT_STRING, serialize(new MongoDate($sec, $usec)), "\n";
    }

    // Create more helpers when needed
}

