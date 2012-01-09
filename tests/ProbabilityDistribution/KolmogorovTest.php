<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/Kolmogorov.php');

use \PHPStats\ProbabilityDistribution\Kolmogorov as Kolmogorov;

class KolmogorovTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new Kolmogorov(0.5, 5);
	}

	public function test_rvs() {
		$variates = 1000;
		$max_tested = 10;
		$expected = array();
		$observed = array();
		
		for ($i = 0; $i < $variates; $i++) {
			$variate = $this->testObject->rvs();
			
			if ($variate < $max_tested)
				$observed[$variate]++;
			else
				$observed[$max_tested]++;
		}
		
		for ($i = 0; $i < $max_tested; $i++) {
			$expected[$i] = $variates * $this->testObject->pmf($i);
		}
		$expected[$max_tested] = $variates * $this->testObject->sf($max_tested - 1);
		
		$this->assertLessThan(0.01, \PHPStats\statisticalTests::chiSquareTest($observed, $expected, $max_tested));
	}

	public function test_pmf() {
		$this->assertEquals(0.3125, $this->testObject->pmf(2));
	}

	public function test_cdf() {
		$this->assertEquals(0.5, $this->testObject->cdf(2));
	}

	public function test_sf() {
		$this->assertEquals(0.5, $this->testObject->sf(2));
	}

	public function test_ppf() {
		$this->assertEquals(2, $this->testObject->ppf(0.5));
	}

	public function test_isf() {
		$this->assertEquals(2, $this->testObject->isf(0.5));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(2.5, $summaryStats['mean']);
		$this->assertEquals(1.25, $summaryStats['variance']);
		$this->assertEquals(0, $summaryStats['skew']);
		$this->assertEquals(-0.4, $summaryStats['kurtosis']);
	}
}
?>