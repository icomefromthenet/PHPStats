<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/LogNormal.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\LogNormal as LogNormal;

class LogNormalTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new LogNormal(3, 2.25);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(0.04076, round($this->testObject->pdf(2), 5));
		$this->assertEquals(0.02968, round($this->testObject->pdf(7), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.1, round($this->testObject->cdf(2.93783), 5));
		$this->assertEquals(0.25, round($this->testObject->cdf(7.30286), 5));
		$this->assertEquals(0.5, round($this->testObject->cdf(20.0855), 5));
		$this->assertEquals(0.75, round($this->testObject->cdf(55.2426), 4));
		$this->assertEquals(0.9, round($this->testObject->cdf(137.322), 3));
	}

	public function test_sf() {
		$this->assertEquals(0.9, round($this->testObject->sf(2.93783), 5));
		$this->assertEquals(0.75, round($this->testObject->sf(7.30286), 5));
		$this->assertEquals(0.5, round($this->testObject->sf(20.0855), 5));
		$this->assertEquals(0.25, round($this->testObject->sf(55.2426), 4));
		$this->assertEquals(0.1, round($this->testObject->sf(137.322), 3));
	}

	public function test_ppf() {
		$this->assertEquals(2.97111, round($this->testObject->ppf(0.1), 5));
		$this->assertEquals(7.30296, round($this->testObject->ppf(0.25), 5));
		$this->assertEquals(20.08554, round($this->testObject->ppf(0.5), 5));
		$this->assertEquals(55.24183, round($this->testObject->ppf(0.75), 5));
		$this->assertEquals(135.78371, round($this->testObject->ppf(0.9), 5));
	}

	public function test_isf() {
		$this->assertEquals(2.97111, round($this->testObject->isf(0.9), 5));
		$this->assertEquals(7.30296, round($this->testObject->isf(0.75), 5));
		$this->assertEquals(20.08554, round($this->testObject->isf(0.5), 5));
		$this->assertEquals(55.24183, round($this->testObject->isf(0.25), 5));
		$this->assertEquals(135.78371, round($this->testObject->isf(0.1), 5));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(61.8678, round($summaryStats['mean'], 4));
		$this->assertEquals(32487.9, round($summaryStats['variance'], 1));
		$this->assertEquals(33.468, round($summaryStats['skew'], 3));
		$this->assertEquals(10075.3, round($summaryStats['kurtosis'], 1));
	}
}
