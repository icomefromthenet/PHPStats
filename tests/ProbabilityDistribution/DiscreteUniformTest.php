<?php
require_once('lib/Stats.php');
require_once('lib/ProbabilityDistribution/ProbabilityDistribution.php');
require_once('lib/ProbabilityDistribution/DiscreteUniform.php');

use \PHPStats\ProbabilityDistribution\DiscreteUniform as DiscreteUniform;

class DiscreteUniformTest extends PHPUnit_Framework_TestCase {
	private $testObject;

	public function __construct() {
		$this->testObject = new DiscreteUniform(1, 10);
	}

	public function test_rvs() {
		$variates = 10000;
		$max_tested = 10;
		$expected = array();
		$observed = array();

		for ($i = 0; $i <= $max_tested; $i++) {
			$expected[] = 0;
			$observed[] = 0;
		}
		
		for ($i = 1; $i < $variates; $i++) {
			$variate = $this->testObject->rvs();
			
			if ($variate < $max_tested)
				$observed[$variate]++;
			else
				$observed[$max_tested]++;
		}
		
		for ($i = 1; $i < $max_tested; $i++) {
			$expected[$i] = $variates * $this->testObject->pmf($i);
		}
		$expected[$max_tested] = $variates * $this->testObject->sf($max_tested - 1);
		
		$this->assertGreaterThanOrEqual(0.01, \PHPStats\statisticalTests::chiSquareTest($observed, $expected, $max_tested - 1));
		$this->assertLessThanOrEqual(0.99, \PHPStats\statisticalTests::chiSquareTest($observed, $expected, $max_tested - 1));
	}

	public function test_pmf() {
		$this->assertEquals(0.1, $this->testObject->pmf(4));
	}

	public function test_cdf() {
		$this->assertEquals(0.4, $this->testObject->cdf(4));
	}

	public function test_sf() {
		$this->assertEquals(0.6, $this->testObject->sf(4));
	}

	public function test_ppf() {
		$this->assertEquals(2, $this->testObject->ppf(0.2));
	}

	public function test_isf() {
		$this->assertEquals(9, $this->testObject->isf(0.2));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(5.5, $summaryStats['mean']);
		$this->assertEquals(8.33333, round($summaryStats['variance'], 5));
		$this->assertEquals(0, $summaryStats['skew']);
		$this->assertEquals(-1.22424, round($summaryStats['kurtosis'], 5));
	}
}
?>
