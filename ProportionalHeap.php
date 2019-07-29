<?php

class ProportionalHeapException extends Exception
{
}

/**
 * Proportional Heap it's a class that obtain association array with int digit values (nodes) and perform proportional
 * balance source value between nodes.
 *
 * @author Aleksandr Chernyi <iblasterus@gmail.com>
 * @date 07/29/2019
 */
class ProportionalHeap
{
    /**
     * Source
     *
     * @var int $source source that will be proportional distribute between nodes
     */
    private $source;

    /**
     * Nodes
     *
     * @var array of int digit values (nodes)
     */
    private $nodes = array();

    /**
     * ProportionalHeap constructor.
     *
     * @param int $source source that will be proportional distribute between nodes (default = 100)
     * @param array $nodes
     * @throws ProportionalHeapException
     */
    public function __construct($source = 100, array $nodes = array())
    {
        $this->source = (int)$source;
        $this->checkSource();
        $this->nodes = $nodes;
        $this->checkNodes();
        $this->processing();
    }

    /**
     * Return the value of source
     *
     * @return int value of source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set source
     *
     * @param int $source value of source
     * @throws ProportionalHeapException
     */
    public function setSource($source)
    {
        $this->source = $source;
        $this->checkSource();
        $this->processing();
    }

    /**
     * Return nodes array
     *
     * @return array nodes
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Set nodes
     *
     * @param array $nodes
     * @throws ProportionalHeapException
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;
        $this->checkNodes();
        $this->processing();
    }

    /**
     * Check source and cast it to int
     *
     * @throws ProportionalHeapException
     */
    private function checkSource() {
        if (!is_numeric($this->source)) {
            throw new ProportionalHeapException("Source is not a number");
        } elseif ($this->source < 0) {
            throw new ProportionalHeapException('Source less than 0');
        } elseif (!is_int($this->source)) {
            $this->source = (int) round($this->source);
        }
    }

    /**
     * Check nodes and cast them to int
     *
     * @throws ProportionalHeapException
     */
    private function checkNodes()
    {
        if(!is_array($this->nodes)) throw new ProportionalHeapException('Nodes is not an array');
        foreach ($this->nodes as $key => $value) {
            if (!is_numeric($value)) {
                throw new ProportionalHeapException("Node {$key} is not a number ({$value})");
            } elseif ($value < 0) {
                throw new ProportionalHeapException("Node {$key} less than 0 ({$value})");
            } elseif (!is_int($value)) {
                $this->nodes[$key] = (int) round($value);
            }
        }
    }

    /**
     * Proportional calculation each node in the way that their sum equal to source
     */
    private function processing() {
        $result = array();
        foreach($this->nodes as $key => $value) {
            $sum = 1.0;
            foreach($this->nodes as $key_s => $value_s) {
                if($this->nodes[$key_s] != $this->nodes[$key]) {
                    $sum += $this->nodes[$key_s] / $this->nodes[$key];
                }
                $result[$key] = (int) round($this->source / $sum);
            }
        }

        // Correcting rounding error
        while (array_sum($result) != $this->source) {
            if(count($result) > 0) {
                $max_key = array_keys($result, max($result))[0];
                if (array_sum($result) > $this->source) {
                    $result[$max_key]--;
                } else {
                    $result[$max_key]++;
                }
            } else {
                break;
            }
        }

        $this->nodes = $result;
    }
}