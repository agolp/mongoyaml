<?php

require_once '../MongoYaml.php';

// This example loads the dynamic fixtures from the file 'project.yml'
// into various collections of the 'test' database
$mongo = new Mongo();
$loader = new MongoYaml($mongo->test);
$loader->load('project.yml');
