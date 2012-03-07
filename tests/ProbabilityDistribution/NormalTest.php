<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/Normal.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\Normal as Normal;

class NormalTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new Normal(10, 25);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(0.02218, round($this->testObject->pdf(2), 5));
		$this->assertEquals(0.06664, round($this->testObject->pdf(7), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.5, round($this->testObject->cdf(10), 5));
		$this->assertEquals(0.9, round($this->testObject->cdf(16.4078), 5));
	}

	public function test_sf() {
		$this->assertEquals(0.5, round($this->testObject->sf(10), 5));
		$this->assertEquals(0.1, round($this->testObject->sf(16.4078), 5));
	}

	public function test_ppf() {
		$this->assertEquals(10, $this->testObject->ppf(0.5));
		$this->assertEquals(16.3702, round($this->testObject->ppf(0.9), 4));
	}

	public function test_isf() {
		$this->assertEquals(10, $this->testObject->isf(0.5));
		$this->assertEquals(3.62979, round($this->testObject->isf(0.9), 5));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(10, $summaryStats['mean']);
		$this->assertEquals(25, $summaryStats['variance']);
		$this->assertEquals(0, $summaryStats['skew']);
		$this->assertEquals(0, $summaryStats['kurtosis']);
	}
}
?>
