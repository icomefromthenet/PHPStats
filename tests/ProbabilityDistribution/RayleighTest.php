<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/Weibull.php');
require_once('lib/ProbabilityDistribution/Rayleigh.php');

use \PHPStats\ProbabilityDistribution\Rayleigh as Rayleigh;

class RayleighTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new Rayleigh(2);
	}

	public function test_rvs() {
		//$this->assertEquals(, $this->testObject->rvs());
	}

	public function test_pdf() {
		$this->assertEquals(0.22062, round($this->testObject->pdf(1), 5));
		$this->assertEquals(0.12115, round($this->testObject->pdf(0.5), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.25, round($this->testObject->cdf(1.51706), 5));
		$this->assertEquals(0.5, round($this->testObject->cdf(2.35482), 5));
	}

	public function test_sf() {
		$this->assertEquals(0.75, round($this->testObject->sf(1.51706), 5));
		$this->assertEquals(0.5, round($this->testObject->sf(2.35482), 5));
	}

	public function test_ppf() {
		$this->assertEquals(1.51706, round($this->testObject->ppf(0.25), 5));
		$this->assertEquals(2.35482, round($this->testObject->ppf(0.5), 5));
	}

	public function test_isf() {
		$this->assertEquals(1.51706, round($this->testObject->isf(0.75), 5));
		$this->assertEquals(2.35482, round($this->testObject->isf(0.5), 5));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(2.50663, round($summaryStats['mean'], 5));
		$this->assertEquals(1.71681, round($summaryStats['variance'], 5));
		$this->assertEquals(0.63111, round($summaryStats['skew'], 5));
		$this->assertEquals(0.24509, round($summaryStats['kurtosis'], 5));
	}
}
?>
