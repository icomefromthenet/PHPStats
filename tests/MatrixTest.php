<?php

//{{1,2,3,4},{5,6,7,8},{9,10,11,12},{13,14,15,16}}*{{3,6,2,7},{4,1,6,3},{8,5,8,3},{1,7,9,0}}

require_once('lib/Stats.php');
require_once('lib/Matrix.php');

use \PHPStats\Matrix as Matrix;

class MatrixTest extends PHPUnit_Framework_TestCase {
	private $matrixA;
	private $matrixB;
	
	function __construct() {
		$this->matrixA = new Matrix('[1, 2, 3, 4; 5, 6, 7, 8; 9, 10, 11, 12; 13, 14, 15, 16]');
		$this->matrixB = new Matrix('[3, 6, 2, 7; 4, 1, 6, 3; 8, 5, 8, 3; 1, 7, 9, 0]');
	}
	
	function test_getElement() {
		$this->assertEquals(7, $this->matrixA->getElement(2, 3));
	}
	
	function test_setElement() {
		$this->matrixA->setElement(2, 3, 99);
		
		$this->assertEquals(99, $this->matrixA->getElement(2, 3));
		
		$this->matrixA->setElement(2, 3, 7);
	}
	
	function test_getRows() {
		$this->assertEquals(4, $this->matrixA->getRows());
	}
	
	function test_getColumns() {
		$this->assertEquals(4, $this->matrixA->getColumns());
	}
	
	function test_add() {
		$sum = $this->matrixA->add($this->matrixB);
		
		$this->assertEquals(4, $sum->getElement(1, 1));
		$this->assertEquals(8, $sum->getElement(1, 2));
		$this->assertEquals(5, $sum->getElement(1, 3));
		$this->assertEquals(11, $sum->getElement(1, 4));
		$this->assertEquals(9, $sum->getElement(2, 1));
		$this->assertEquals(7, $sum->getElement(2, 2));
		$this->assertEquals(13, $sum->getElement(2, 3));
		$this->assertEquals(11, $sum->getElement(2, 4));
		$this->assertEquals(17, $sum->getElement(3, 1));
		$this->assertEquals(15, $sum->getElement(3, 2));
		$this->assertEquals(19, $sum->getElement(3, 3));
		$this->assertEquals(15, $sum->getElement(3, 4));
		$this->assertEquals(14, $sum->getElement(4, 1));
		$this->assertEquals(21, $sum->getElement(4, 2));
		$this->assertEquals(24, $sum->getElement(4, 3));
		$this->assertEquals(16, $sum->getElement(4, 4));
	}
	
	function test_reduce() {
		$reduction = $this->matrixA->reduce(2, 3);
		
		$this->assertEquals(1, $reduction->getElement(1, 1));
		$this->assertEquals(2, $reduction->getElement(1, 2));
		$this->assertEquals(4, $reduction->getElement(1, 3));
		$this->assertEquals(9, $reduction->getElement(2, 1));
		$this->assertEquals(10, $reduction->getElement(2, 2));
		$this->assertEquals(12, $reduction->getElement(2, 3));
		$this->assertEquals(13, $reduction->getElement(3, 1));
		$this->assertEquals(14, $reduction->getElement(3, 2));
		$this->assertEquals(16, $reduction->getElement(3, 3));
	}
	
	function test_substract() {
		$difference = $this->matrixA->subtract($this->matrixB);
		
		$this->assertEquals(-2, $difference->getElement(1, 1));
		$this->assertEquals(-4, $difference->getElement(1, 2));
		$this->assertEquals(1, $difference->getElement(1, 3));
		$this->assertEquals(-3, $difference->getElement(1, 4));
		$this->assertEquals(1, $difference->getElement(2, 1));
		$this->assertEquals(5, $difference->getElement(2, 2));
		$this->assertEquals(1, $difference->getElement(2, 3));
		$this->assertEquals(5, $difference->getElement(2, 4));
		$this->assertEquals(1, $difference->getElement(3, 1));
		$this->assertEquals(5, $difference->getElement(3, 2));
		$this->assertEquals(3, $difference->getElement(3, 3));
		$this->assertEquals(9, $difference->getElement(3, 4));
		$this->assertEquals(12, $difference->getElement(4, 1));
		$this->assertEquals(7, $difference->getElement(4, 2));
		$this->assertEquals(6, $difference->getElement(4, 3));
		$this->assertEquals(16, $difference->getElement(4, 4));
	}
	
	function test_scalarMultiply() {
		$product = $this->matrixA->scalarMultiply(2);
		
		$this->assertEquals(2, $product->getElement(1, 1));
		$this->assertEquals(4, $product->getElement(1, 2));
		$this->assertEquals(6, $product->getElement(1, 3));
		$this->assertEquals(8, $product->getElement(1, 4));
		$this->assertEquals(10, $product->getElement(2, 1));
		$this->assertEquals(12, $product->getElement(2, 2));
		$this->assertEquals(14, $product->getElement(2, 3));
		$this->assertEquals(16, $product->getElement(2, 4));
		$this->assertEquals(18, $product->getElement(3, 1));
		$this->assertEquals(20, $product->getElement(3, 2));
		$this->assertEquals(22, $product->getElement(3, 3));
		$this->assertEquals(24, $product->getElement(3, 4));
		$this->assertEquals(26, $product->getElement(4, 1));
		$this->assertEquals(28, $product->getElement(4, 2));
		$this->assertEquals(30, $product->getElement(4, 3));
		$this->assertEquals(32, $product->getElement(4, 4));
	}

	function test_trace() {
		$this->assertEquals(12, $this->matrixB->trace());
	}
	
	function test_dotMultiply() {
		$product = $this->matrixA->dotMultiply($this->matrixB);

		$this->assertEquals(39, $product->getElement(1, 1));
		$this->assertEquals(51, $product->getElement(1, 2));
		$this->assertEquals(74, $product->getElement(1, 3));
		$this->assertEquals(22, $product->getElement(1, 4));
		$this->assertEquals(103, $product->getElement(2, 1));
		$this->assertEquals(127, $product->getElement(2, 2));
		$this->assertEquals(174, $product->getElement(2, 3));
		$this->assertEquals(74, $product->getElement(2, 4));
		$this->assertEquals(167, $product->getElement(3, 1));
		$this->assertEquals(203, $product->getElement(3, 2));
		$this->assertEquals(274, $product->getElement(3, 3));
		$this->assertEquals(126, $product->getElement(3, 4));
		$this->assertEquals(231, $product->getElement(4, 1));
		$this->assertEquals(279, $product->getElement(4, 2));
		$this->assertEquals(374, $product->getElement(4, 3));
		$this->assertEquals(178, $product->getElement(4, 4));
	}
	
	function test_determinant() {
		$this->assertEquals(0, $this->matrixA->determinant());
		$this->assertEquals(-1656, $this->matrixB->determinant());
	}
	
	function test_transpose() {
		$transpose = $this->matrixA->transpose();
		
		$this->assertEquals(1, $transpose->getElement(1, 1));
		$this->assertEquals(5, $transpose->getElement(1, 2));
		$this->assertEquals(9, $transpose->getElement(1, 3));
		$this->assertEquals(13, $transpose->getElement(1, 4));
		$this->assertEquals(2, $transpose->getElement(2, 1));
		$this->assertEquals(6, $transpose->getElement(2, 2));
		$this->assertEquals(10, $transpose->getElement(2, 3));
		$this->assertEquals(14, $transpose->getElement(2, 4));
		$this->assertEquals(3, $transpose->getElement(3, 1));
		$this->assertEquals(7, $transpose->getElement(3, 2));
		$this->assertEquals(11, $transpose->getElement(3, 3));
		$this->assertEquals(15, $transpose->getElement(3, 4));
		$this->assertEquals(4, $transpose->getElement(4, 1));
		$this->assertEquals(8, $transpose->getElement(4, 2));
		$this->assertEquals(12, $transpose->getElement(4, 3));
		$this->assertEquals(16, $transpose->getElement(4, 4));
	}
	
	function test_inverse() {
		$inverse = $this->matrixB->inverse()->scalarMultiply(1656); //Scale by determinant to get whole numbers
		
		$this->assertEquals(-66, $inverse->getElement(1, 1));
		$this->assertEquals(-197, $inverse->getElement(1, 2));
		$this->assertEquals(351, $inverse->getElement(1, 3));
		$this->assertEquals(-166, $inverse->getElement(1, 4));
		$this->assertEquals(102, $inverse->getElement(2, 1));
		$this->assertEquals(-373, $inverse->getElement(2, 2));
		$this->assertEquals(135, $inverse->getElement(2, 3));
		$this->assertEquals(106, round($inverse->getElement(2, 4)));
		$this->assertEquals(-72, $inverse->getElement(3, 1));
		$this->assertEquals(312, $inverse->getElement(3, 2));
		$this->assertEquals(-144, $inverse->getElement(3, 3));
		$this->assertEquals(120, $inverse->getElement(3, 4));
		$this->assertEquals(198, round($inverse->getElement(4, 1)));
		$this->assertEquals(315, $inverse->getElement(4, 2));
		$this->assertEquals(-225, $inverse->getElement(4, 3));
		$this->assertEquals(-54, $inverse->getElement(4, 4));
	}
	
	function test_pow() {
		$power = $this->matrixB->pow(3);
		
		$this->assertEquals(1513, $power->getElement(1, 1));
		$this->assertEquals(1339, $power->getElement(1, 2));
		$this->assertEquals(1983, $power->getElement(1, 3));
		$this->assertEquals(1004, $power->getElement(1, 4));
		$this->assertEquals(1266, $power->getElement(2, 1));
		$this->assertEquals(1266, $power->getElement(2, 2));
		$this->assertEquals(1743, $power->getElement(2, 3));
		$this->assertEquals(964, $power->getElement(2, 4));
		$this->assertEquals(1980, $power->getElement(3, 1));
		$this->assertEquals(2130, $power->getElement(3, 2));
		$this->assertEquals(2857, $power->getElement(3, 3));
		$this->assertEquals(1530, $power->getElement(3, 4));
		$this->assertEquals(1524, $power->getElement(4, 1));
		$this->assertEquals(1641, $power->getElement(4, 2));
		$this->assertEquals(1977, $power->getElement(4, 3));
		$this->assertEquals(1243, $power->getElement(4, 4));
	}
	
	function test_numericConstructor() {
		//Instantiate a matrix using the numeric constructor and then multiply it against our test one, to test identity multiplication
		$identity = Matrix::identity(4);
		$multiplied = $this->matrixB->dotMultiply($identity);

		for ($i = 1; $i <= $multiplied->getRows(); $i++) {
			for ($j = 1; $j <= $multiplied->getColumns(); $j++) {
				$this->assertEquals($this->matrixB->getElement($i, $j), $multiplied->getElement($i, $j));
			}
		}
	}
}
