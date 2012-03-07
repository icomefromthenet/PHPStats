<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/ChiSquare.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\ChiSquare as ChiSquare;

class ChiSquareTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new ChiSquare(5);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(0.14398, round($this->testObject->pdf(4), 5));
		$this->assertEquals(0.05511, round($this->testObject->pdf(8), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.5, round($this->testObject->cdf(4.35146), 4));
		$this->assertEquals(0.9, round($this->testObject->cdf(9.23636), 4));
	}

	public function test_sf() {
		$this->assertEquals(0.5, round($this->testObject->sf(4.35146), 5));
		$this->assertEquals(0.1, round($this->testObject->sf(9.23636), 4));
	}

	/*public function test_ppf() {
		$this->assertEquals(4.35144, round($this->testObject->ppf(0.5), 5));
		$this->assertEquals(9.23636, round($this->testObject->ppf(0.9), 5));
	}

	public function test_isf() {
		$this->assertEquals(4.35144, round($this->testObject->isf(0.5), 5));
		$this->assertEquals(1.61030, round($this->testObject->isf(0.9), 5));
	}*/

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(5, round($summaryStats['mean'], 5));
		$this->assertEquals(10, round($summaryStats['variance'], 5));
		$this->assertEquals(1.26491, round($summaryStats['skew'], 5));
		$this->assertEquals(2.4, round($summaryStats['kurtosis'], 5));
	}
}
?>
