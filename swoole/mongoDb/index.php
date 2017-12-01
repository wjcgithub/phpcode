<?php

//mongoDb.so
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
var_dump($manager);

// mongo.so
$mc = new MongoClient("mongodb://localhost:27017", ["ssl" => false]);
var_dump($mc);
