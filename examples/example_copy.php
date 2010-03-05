<?php

require_once '../MongoYaml.php';

$mongo = new Mongo();

// This example shows a simple way to copy collections from one table to another
$blogloader = new MongoYaml($mongo->blog);
$blogloader->dump('posts')
           ->dump('users');

$testloader = new MongoYaml($mongo->test);
$testloader->load('posts.yml')
           ->load('users.yml');
