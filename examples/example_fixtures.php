<?php

require '../MongoYaml.php';

// This example loads the dynamic fixtures from the file 'project.yml'
// in various collections of the 'test' database
$mongo = new Mongo();
$loader = new MongoYaml($mongo->test);
$loader->load('project.yml');
