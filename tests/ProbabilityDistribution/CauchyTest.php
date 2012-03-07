<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/Normal.php');
require_once('lib/ProbabilityDistribution/Cauchy.php');
require_once('lib/StatisticalTests.php');

use \PHPStats\ProbabilityDistribution\Cauchy as Cauchy;

class CauchyTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new Cauchy(10, 5);
	}

	public function test_rvs() {
		$variates = array();
		for ($i = 0; $i < 10000; $i++) $variates[] = $this->testObject->rvs();
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
		$this->assertLessThanOrEqual(0.99, \PHPStats\StatisticalTests::kolmogorovSmirnov($variates, $this->testObject));
	}

	public function test_pdf() {
		$this->assertEquals(0.01273, round($this->testObject->pdf(0), 5));
		$this->assertEquals(0.02151, round($this->testObject->pdf(3), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.14758, round($this->testObject->cdf(0), 5));
		$this->assertEquals(0.19743, round($this->testObject->cdf(3), 5));
	}

	public function test_sf() {
		$this->assertEquals(0.85242, round($this->testObject->sf(0), 5));
		$this->assertEquals(0.80257, round($this->testObject->sf(3), 5));
	}

	public function test_ppf() {
		$this->assertEquals(0, round($this->testObject->ppf(0.14758), 3));
		$this->assertEquals(3, round($this->testObject->ppf(0.19743), 3));
	}

	public function test_isf() {
		$this->assertEquals(0, round($this->testObject->isf(0.85242), 3));
		$this->assertEquals(3, round($this->testObject->isf(0.80257), 3));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertTrue(is_nan($summaryStats['mean']));
		$this->assertTrue(is_nan($summaryStats['variance']));
		$this->assertTrue(is_nan($summaryStats['skew']));
		$this->assertTrue(is_nan($summaryStats['kurtosis']));
	}
}
?>
