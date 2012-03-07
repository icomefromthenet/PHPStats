<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/Beta.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\Beta as Beta;

class BetaTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new Beta(10, 5);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(0.00210, round($this->testObject->pdf(0.2), 5));
		$this->assertEquals(3.27191, round($this->testObject->pdf(0.7), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.5, round($this->testObject->cdf(0.674249), 5));
		$this->assertEquals(0.9, round($this->testObject->cdf(0.814866), 5));
	}

	public function test_sf() {
		$this->assertEquals(0.5, round($this->testObject->sf(0.674249), 5));
		$this->assertEquals(0.1, round($this->testObject->sf(0.814866), 5));
	}

	public function test_ppf() {
		$this->assertEquals(0.674249, round($this->testObject->ppf(0.5), 6));
		$this->assertEquals(0.814866, round($this->testObject->ppf(0.9), 6));
	}

	public function test_isf() {
		$this->assertEquals(0.674249, round($this->testObject->isf(0.5), 6));
		$this->assertEquals(0.508035, round($this->testObject->isf(0.9), 6));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(0.66667, round($summaryStats['mean'], 5));
		$this->assertEquals(0.01389, round($summaryStats['variance'], 5));
		$this->assertEquals(-0.33276, round($summaryStats['skew'], 5));
		$this->assertEquals(-0.17647, round($summaryStats['kurtosis'], 5));
	}
}
?>
