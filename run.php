<?php

require_once 'vendor/autoload.php';

use NodeSetCollection\Models\Node;
use NodeSetCollection\NodeCollection;

function run()
{
    $collection1 = NodeCollection::create('a/1, a/2, a/3, a/a, a/128, a/129, b/65, b/66, c/1, c/10, c/42');

    $collection2 = NodeCollection::create('a/1, a/2, a/3, a/4 a/5, a/126, a/127, b/100, c/2, c/3, d/1');

    return  $collection1
        ->merge($collection2)
        ->unique()
        ->sort(function (Node $item1, Node $item2) {
            return $item1->compareWith($item2);
        });

}

printf(run() . PHP_EOL );