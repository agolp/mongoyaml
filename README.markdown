MongoYaml
=========
About
-----

MongoYaml is a simple PHP tool aiming to ease imports / exports in MongoDB by using the YAML format (http://yaml.org)


Use cases
---------

1.  **Simple imports / exports**:

    This code sample copies two collections from the database blog to the database test.

        <?php
        require_once '../MongoYaml.php';
        $mongo = new Mongo();

        $blogloader = new MongoYaml($mongo->blog);
        $blogloader->dump('posts')
                   ->dump('users');

        $testloader = new MongoYaml($mongo->test);
        $testloader->load('posts.yml')
                   ->load('users.yml');

2.  **Clean fixtures for unit-tests**:

    Inspired by the symfony framework:

        <?php
        require_once '../MongoYaml.php';

        $mongo = new Mongo();
        $loader = new MongoYaml($mongo->test);
        $loader->load('project.yml');


    project.yml:

        # By convention, the first key below is the collection name
        # This file creates two collections users and posts
        users:
          j.doe:
            _id: j.doe
            firstname: John
            lastname: Doe
          mickey:
            _id: mickey
            firstname: Mickey
            lastname: Mouse

        # You can use PHP to generate dynamic fixtures,
        # don't forget to print a "\n" if you use PHP at the very end of a line
        posts:
        <?php for($p = 1; $p <= 15; ++$p): ?>
          Post<?php echo $p ?>:
            author: j.doe
            title:  "Title for post number <?php echo $p ?>"
            content: >
              This is great content for 
              post number <?php echo $p, "\n" ?>
            timestamp: <?php MongoYaml::Date() ?>
            comments:
        <?php for($c = 1; $c <= 3; ++$c): ?>
              -
                _id:     <?php MongoYaml::Id() ?>
                author:  mickey
                content: "Comment <?php echo $c ?> for post <?php echo $p ?>"
        <?php endfor ?>
        <?php endfor ?>

License
-------

The program is provided under an MIT open source license. Read the [http://github.com/Armand/mongoyaml/blob/master/LICENSE](LICENSE) file for details.

Credits
-------

This tool was created by Armand Golpaygani as a simple extension to the sfYaml package written by Fabien Potencier for the symfony framework (http://components.symfony-project.org/yaml/).
