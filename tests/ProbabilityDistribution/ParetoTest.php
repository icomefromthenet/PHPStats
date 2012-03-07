<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/Pareto.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\Pareto as Pareto;

class ParetoTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new Pareto(1, 5);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(1.67449, round($this->testObject->pdf(1.2), 5));
		$this->assertEquals(0.29802, round($this->testObject->pdf(1.6), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.5, round($this->testObject->cdf(1.1487), 3));
		$this->assertEquals(0.9, round($this->testObject->cdf(1.58489), 3));
	}

	public function test_sf() {
		$this->assertEquals(0.5, round($this->testObject->sf(1.1487), 3));
		$this->assertEquals(0.1, round($this->testObject->sf(1.58489), 3));
	}

	public function test_ppf() {
		$this->assertEquals(1.1487, round($this->testObject->ppf(0.5), 4));
		$this->assertEquals(1.58489, round($this->testObject->ppf(0.9), 5));
	}

	public function test_isf() {
		$this->assertEquals(1.1487, round($this->testObject->isf(0.5), 4));
		$this->assertEquals(1.58489, round($this->testObject->isf(0.1), 5));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(1.25, round($summaryStats['mean'], 2));
		$this->assertEquals(0.10417, round($summaryStats['variance'], 5));
		$this->assertEquals(4.64758, round($summaryStats['skew'], 5));
		$this->assertEquals(70.8, round($summaryStats['kurtosis'], 1));
	}
}
?>
