<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/Levy.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\Levy as Levy;

class LevyTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new Levy(0, 1);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(0.24197, round($this->testObject->pdf(1), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.31731, round($this->testObject->cdf(1), 5));
	}

	public function test_sf() {
		$this->assertEquals(0.68269, round($this->testObject->sf(1), 5));
	}

	public function test_ppf() {
		$this->assertEquals(1, round($this->testObject->ppf(0.31731), 2));
	}

	public function test_isf() {
		$this->assertEquals(1, round($this->testObject->isf(0.68269), 2));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(INF, $summaryStats['mean']);
		$this->assertEquals(INF, $summaryStats['variance']);
		$this->assertEquals(NAN, $summaryStats['skew']);
		$this->assertEquals(NAN, $summaryStats['kurtosis']);
	}
}
?>
