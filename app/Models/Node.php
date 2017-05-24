<?php
/**
 * Created by PhpStorm.
 * User: robert.aproniu
 * Date: 23/05/2017
 * Time: 21:06
 */

namespace NodeSetCollection\Models;


use SortableCollection\Contracts\PrintableInterface;

class Node implements PrintableInterface
{
    private $string;

    private $number;

    public function set(string $string, int $number) : Node
    {
        $this->string = $string;

        $this->number = $number;

        return $this;
    }

    public function compareWith(Node $node) : bool
    {
        $stringDiff = $this->string <=> $node->getString();

        if ($stringDiff === -1) {
            return false;
        }

        if ($stringDiff === 1) {
            return true;
        }

        return $this->number  > $node->getNumber();
    }

    function __toString() : string
    {
        return "{$this->string} {$this->number}";
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getString(): string
    {
        return $this->string;
    }
}
