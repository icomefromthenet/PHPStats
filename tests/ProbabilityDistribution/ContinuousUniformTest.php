<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/ContinuousUniform.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\ContinuousUniform as ContinuousUniform;

class ContinuousUniformTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new ContinuousUniform(1, 10);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(0.11111, round($this->testObject->pdf(4), 5));
		$this->assertEquals(0.11111, round($this->testObject->pdf(8), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.3333, round($this->testObject->cdf(4), 4));
		$this->assertEquals(0.8889, round($this->testObject->cdf(9), 4));
	}

	public function test_sf() {
		$this->assertEquals(0.66667, round($this->testObject->sf(4), 5));
		$this->assertEquals(0.1111, round($this->testObject->sf(9), 4));
	}

	public function test_ppf() {
		$this->assertEquals(4, round($this->testObject->ppf(0.33333), 4));
		$this->assertEquals(9, round($this->testObject->ppf(0.88889), 4));
	}

	public function test_isf() {
		$this->assertEquals(7, round($this->testObject->isf(0.33333), 4));
		$this->assertEquals(2, round($this->testObject->isf(0.88889), 4));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(5.5, round($summaryStats['mean'], 5));
		$this->assertEquals(6.75, round($summaryStats['variance'], 5));
		$this->assertEquals(0, round($summaryStats['skew'], 5));
		$this->assertEquals(-1.2, round($summaryStats['kurtosis'], 5));
	}
}
?>
