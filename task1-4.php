<?php
// 1. 0,1,1,2,3,5,8,13,21,34,55 (Fibonachi seq)
// 2. 
	/**
     * Add two numbers together and return the result
     * 
     * @param mixed $a
     * @param mixed $b
     * @return mixed
     */
    function sum($a, $b)
    {
        return $a + $b;
    }
	
	 /**
     * Subtract $b from $a and return the result
     * 
     * @praam mixed $a
     * @param mixed $b
     * @return mixed
     */
    function subtract($a, $b)
    {
        return $a - $b;
    }
	
    /**
     * Divide $a by $b and return the result
     *
     * @param mixed $a
     * @param mixed $b
     * @return mixed
     */
    function divide($a, $b)
    {
        return $a / $b;
    }
	
    /**
     * Return $int cubed
     *
     * @param int $int
     * @return int
     */
    function cube(int $a) : int
    {
        return pow($a,3);
    }
	
// 4. 
    function findBozboz($array)
    {
    	$index = array_search('Bozboz', $array);
        return $index === false ? -1 : $index;
    }

    echo sum(2,3) . "\n";
    echo subtract(2,3) . "\n";
    echo divide(2,3) . "\n";
    echo cube(2) . "\n";
	echo findBozboz(['Bozboz', 'Foo', 'Bar']) . "\n";
	// should return 0

	echo findBozboz(['Foo', 'Bar', 'Baz']) . "\n";
	// Should return -1
	
