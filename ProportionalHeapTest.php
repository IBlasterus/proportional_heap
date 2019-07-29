<?php
require 'ProportionalHeap.php';

/**
 * Tests for ProportionalHeap class with PHPUnit 5.7.27
 */
class ProportionalHeapTest extends PHPUnit_Framework_TestCase
{
    /**
     * Create default object
     *
     * @return ProportionalHeap
     * @throws ProportionalHeapException
     */
    public function testConstructDefault() {
        $ph = new ProportionalHeap();
        return $ph;
    }

    /**
     * Test default params of object
     *
     * @depends testConstructDefault
     */
    public function testDefaultValues($ph) {
        $this->assertEquals(100, $ph->getSource()); // default source can be 100
        $this->assertEquals(0, count($ph->getNodes())); // number of nodes can be 0
    }

    /**
     * Test assignment source
     *
     * @depends testConstructDefault
     */
    public function testAssignmentSource($ph) {
        $ph->setSource(150.5);
        $this->assertEquals(151, $ph->getSource());
        $ph->setSource(100);
        $this->assertEquals(100, $ph->getSource());
    }

    /**
     * Test assignment nodes
     *
     * @depends testConstructDefault
     */
    public function testAssignmentNodes($ph) {
        $nodes = array(
            'first' => 15,
            'second' => 6,
            'third' => 4
        );
        $ph->setNodes($nodes);
        $myNodes = $ph->getNodes();
        $this->assertEquals(60, $myNodes['first']);
        $this->assertEquals(24, $myNodes['second']);
        $this->assertEquals(16, $myNodes['third']);
    }

    /**
     * Test change source
     *
     * @depends testConstructDefault
     */
    public function testChangeSource($ph) {
        $nodes = array(
            'first' => 15,
            'second' => 6,
            'third' => 4
        );
        $ph->setNodes($nodes);
        $ph->setSource(200);
        $myNodes = $ph->getNodes();
        $this->assertEquals(120, $myNodes['first']);
        $this->assertEquals(48, $myNodes['second']);
        $this->assertEquals(32, $myNodes['third']);
    }

    /**
     * Test wrong source
     *
     * @depends testConstructDefault
     * @expectedException ProportionalHeapException
     */
    public function testWrongSource($ph) {
        $ph->setSource("wrong value");
    }

    /**
     * Test wrong nodes
     *
     * @depends testConstructDefault
     * @expectedException ProportionalHeapException
     */
    public function testWrongNodes($ph) {
        $nodes = array(
            'first' => 75,
            'second' => 15,
            'third' => "wrong value"
        );
        $ph->setNodes($nodes);
    }


}
