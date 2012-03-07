<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/Weibull.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\Weibull as Weibull;

class WeibullTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new Weibull(5, 1);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(0.2, round($this->testObject->pdf(0), 5));
		$this->assertEquals(0.14523, round($this->testObject->pdf(1.6), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.5, round($this->testObject->cdf(3.46574), 5));
		$this->assertEquals(0.9, round($this->testObject->cdf(11.5129), 5));
	}

	public function test_sf() {
		$this->assertEquals(0.5, round($this->testObject->sf(3.46574), 5));
		$this->assertEquals(0.1, round($this->testObject->sf(11.5129), 5));
	}

	public function test_ppf() {
		$this->assertEquals(3.46574, round($this->testObject->ppf(0.5), 5));
		$this->assertEquals(11.5129, round($this->testObject->ppf(0.9), 4));
	}

	public function test_isf() {
		$this->assertEquals(3.46574, round($this->testObject->isf(0.5), 5));
		$this->assertEquals(11.5129, round($this->testObject->isf(0.1), 4));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(5, round($summaryStats['mean'], 3));
		$this->assertEquals(25, round($summaryStats['variance'], 2));
		$this->assertEquals(2, round($summaryStats['skew'], 3));
		$this->assertEquals(6, round($summaryStats['kurtosis'], 3));
	}
}
?>
