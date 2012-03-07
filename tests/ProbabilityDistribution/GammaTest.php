<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/Gamma.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\Gamma as Gamma;

class GammaTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new Gamma(10, 5);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(0.02482, round($this->testObject->pdf(40), 5));
		$this->assertEquals(0.01747, round($this->testObject->pdf(60), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.5, round($this->testObject->cdf(48.3436), 4));
		$this->assertEquals(0.9, round($this->testObject->cdf(71.03), 2));
	}

	public function test_sf() {
		$this->assertEquals(0.5, round($this->testObject->sf(48.3436), 5));
		$this->assertEquals(0.1, round($this->testObject->sf(71.03), 5));
	}

	public function test_ppf() {
		$this->assertEquals(48.3436, round($this->testObject->ppf(0.5), 4));
		$this->assertEquals(71.03, round($this->testObject->ppf(0.9), 2));
	}

	public function test_isf() {
		$this->assertEquals(48.3436, round($this->testObject->isf(0.5), 5));
		$this->assertEquals(71.03, round($this->testObject->isf(0.1), 5));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(50, round($summaryStats['mean'], 5));
		$this->assertEquals(250, round($summaryStats['variance'], 5));
		$this->assertEquals(0.63246, round($summaryStats['skew'], 5));
		$this->assertEquals(0.6, round($summaryStats['kurtosis'], 5));
	}
}
?>
