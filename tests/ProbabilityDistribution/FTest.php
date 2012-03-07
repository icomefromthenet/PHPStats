<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/F.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\F as F;

class FTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new F(12, 10);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(0.64389, round($this->testObject->pdf(1), 5));
		$this->assertEquals(0.29981, round($this->testObject->pdf(1.6), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.5, round($this->testObject->cdf(1.01157), 5));
		$this->assertEquals(0.9, round($this->testObject->cdf(2.28405), 5));
	}

	public function test_sf() {
		$this->assertEquals(0.5, round($this->testObject->sf(1.01157), 5));
		$this->assertEquals(0.1, round($this->testObject->sf(2.28405), 5));
	}

	public function test_ppf() {
		$this->assertEquals(1.01157, round($this->testObject->ppf(0.5), 5));
		$this->assertEquals(2.28405, round($this->testObject->ppf(0.9), 5));
	}

	public function test_isf() {
		$this->assertEquals(1.01157, round($this->testObject->isf(0.5), 5));
		$this->assertEquals(2.28405, round($this->testObject->isf(0.1), 5));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(1.25, round($summaryStats['mean'], 5));
		$this->assertEquals(0.86806, round($summaryStats['variance'], 5));
		$this->assertEquals(3.57771, round($summaryStats['skew'], 5));
		$this->assertEquals(44.4, round($summaryStats['kurtosis'], 5));
	}
}
?>
