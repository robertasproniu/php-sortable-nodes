<?php
/**
 * Created by PhpStorm.
 * User: robert.aproniu
 * Date: 23/05/2017
 * Time: 21:35
 */

namespace NodeSetCollection;


use Exception;
use Throwable;
use SortableCollection\Collection\Collection;
use SortableCollection\CollectionFactory;
use SortableCollection\Contracts\Collection\CollectionInterface;
use NodeSetCollection\Models\Node;

class NodeCollection extends CollectionFactory
{
    private $nodeInstance = null;

    public function __construct()
    {
       $this->nodeInstance = new Node();
    }

    public static function create($nodes) : CollectionInterface
    {
        try {
            $items = (new static())->parse($nodes);

            if (empty($items)) {
                throw new Exception('String with nodes can\'t be parsed');
            }

            return new Collection($items);

        } catch (Throwable $exception) {

            die($exception->getMessage().PHP_EOL) ;

        }
    }

    /**
     * Parse given string
     *
     * @param string $nodes
     * @param string $delimiter
     * @return array
     * @throws Exception
     */
    private function parse(string $nodes, $delimiter = "/"): array
    {
        $parsedNodes = [];

        $nodes = (array) preg_split('/[\s,]+/', $nodes);

        foreach ($nodes as $index => $node)
        {
            $params = explode($delimiter, $node);

            if (count($params) < 2)
            {
                throw new Exception("Invalid node on index '{$index}'");
            }

            list($string, $number) = $params;

            if (!is_string($string) || !is_numeric($number))
            {
                throw new Exception("Invalid format for node '{$string}{$delimiter}{$number}' located at index {$index}");
            }

            // add to node
            $parsedNodes[$node] = $this->node($string, $number);

        }

        return array_values($parsedNodes);
    }

    /**
     * Create Node with given params
     *
     * @param $string
     * @param $number
     * @return Node
     */
    private function node($string, $number) : Node
    {
        return (clone $this->nodeInstance)->set($string, $number);
    }
}