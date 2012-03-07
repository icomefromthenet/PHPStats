<?php
/**
 * Note to any reading this file:
 * 
 * A number of these tests use rounded numbers.  That is, we are not testing
 * whether or not something is exactly right, but whether it is close enough.
 * In most cases, this is because certain functions, like the gamma function,
 * require numeric approximations to the real value.  Any efforts to sharpen
 * the corresponding approximations and therefore be able to make the tests
 * accurate to a higher degree would be most welcome.
 */
require_once('lib/Stats.php');
use \PHPStats\Stats as Stats;

class StatsTest extends PHPUnit_Framework_TestCase {
	private $datax;
	private $datay;
	private $dataz;

	function __construct() {
		$this->datax = array(1, 2, 3, 4, 5);
		$this->datay = array(10, 11, 12, 13, 14);
		$this->dataz = array(28.8, 27.1, 42.4, 53.5, 90);
	}

	public function test_sum() {
		$this->assertEquals(15, Stats::sum($this->datax));
		$this->assertEquals(60, Stats::sum($this->datay));
		$this->assertEquals(241.8, Stats::sum($this->dataz));
	}

	public function test_product() {
		$this->assertEquals(120, Stats::product($this->datax));
		$this->assertEquals(240240, Stats::product($this->datay));
		$this->assertEquals(159339674.88, Stats::product($this->dataz));
	}

	public function test_average() {
		$this->assertEquals(3, Stats::average($this->datax));
		$this->assertEquals(12, Stats::average($this->datay));
		$this->assertEquals(48.36, Stats::average($this->dataz));
	}

	public function test_gaverage() {
		$this->assertEquals(2.60517, round(Stats::gaverage($this->datax), 5));
		$this->assertEquals(11.91596, round(Stats::gaverage($this->datay), 5));
		$this->assertEquals(43.69832, round(Stats::gaverage($this->dataz), 5));
	}

	public function test_sumsquared() {
		$this->assertEquals(55, Stats::sumsquared($this->datax));
		$this->assertEquals(730, Stats::sumsquared($this->datay));
		$this->assertEquals(14323.86, Stats::sumsquared($this->dataz));
	}

	public function test_sumXY() {
		$this->assertEquals(190, Stats::sumXY($this->datax, $this->datay));
		$this->assertEquals(3050.4, Stats::sumXY($this->dataz, $this->datay));
	}

	public function test_sse() {
		$this->assertEquals(10, Stats::sse($this->datax));
		$this->assertEquals(10, Stats::sse($this->datay));
		$this->assertEquals(2630.412, Stats::sse($this->dataz));
	}

	public function test_mse() {
		$this->assertEquals(2, Stats::mse($this->datax));
		$this->assertEquals(2, Stats::mse($this->datay));
		$this->assertEquals(526.0824, Stats::mse($this->dataz));
	}

	public function test_covariance() {
		$this->assertEquals(2, Stats::covariance($this->datax, $this->datay));
		$this->assertEquals(29.76, round(Stats::covariance($this->dataz, $this->datay), 2));
	}

	public function test_variance() {
		$this->assertEquals(2, Stats::variance($this->datax));
		$this->assertEquals(2, Stats::variance($this->datay));
		$this->assertEquals(526.0824, round(Stats::variance($this->dataz), 4));
	}

	public function test_stddev() {
		$this->assertEquals(1.41421, round(Stats::stddev($this->datax), 5));
		$this->assertEquals(1.41421, round(Stats::stddev($this->datay), 5));
		$this->assertEquals(22.93649, round(Stats::stddev($this->dataz), 5));
	}

	public function test_sampleStddev() {
		$this->assertEquals(1.58114, round(Stats::sampleStddev($this->datax), 5));
		$this->assertEquals(1.58114, round(Stats::sampleStddev($this->datay), 5));
		$this->assertEquals(25.64377, round(Stats::sampleStddev($this->dataz), 5));
	}

	public function test_correlation() {
		$this->assertEquals(1.0, round(Stats::correlation($this->datax, $this->datay), 5));
		$this->assertEquals(0.91747, round(Stats::correlation($this->dataz, $this->datay), 5));
	}

	public function test_factorial() {
		$this->assertEquals(1, Stats::factorial(0));
		$this->assertEquals(1, Stats::factorial(1));
		$this->assertEquals(2, Stats::factorial(2));
		$this->assertEquals(120, Stats::factorial(5));
		$this->assertEquals(3628800, Stats::factorial(10));
	}

	public function test_erf() {
		$this->assertEquals(-1, round(Stats::erf(-25)));
		$this->assertEquals(0, round(Stats::erf(0), 7));
		$this->assertEquals(0.5205, round(Stats::erf(0.5), 7));
		$this->assertEquals(0.8427007, round(Stats::erf(1), 7));
		$this->assertEquals(0.9661053, round(Stats::erf(1.5), 7));
		$this->assertEquals(0.9953221, round(Stats::erf(2), 7));
		$this->assertEquals(0.9999993, round(Stats::erf(3.5), 7));
	}

	public function test_ierf() {
		$this->assertEquals(0.4769296, round(Stats::ierf(0.5), 7));
		$this->assertEquals(0.2724627, round(Stats::ierf(0.3), 7));
		$this->assertEquals(0.7321501, round(Stats::ierf(0.7), 7));
	}

	public function test_gamma() {
		$this->assertEquals(1, round(Stats::gamma(1), 3));
		$this->assertEquals(1, round(Stats::gamma(2), 3));
		$this->assertEquals(1.3293403881791, round(Stats::gamma(2.5), 13));
		$this->assertEquals(2, round(Stats::gamma(3), 5));
		$this->assertEquals(6, round(Stats::gamma(4), 5));
		$this->assertEquals(24, round(Stats::gamma(5), 5));
		$this->assertEquals(120, round(Stats::gamma(6), 4));
	}

	public function test_gammaln() {
		$this->assertEquals(round(log(1), 3), round(Stats::gammaln(1), 3));
		$this->assertEquals(round(log(1), 3), round(Stats::gammaln(2), 3));
		$this->assertEquals(round(log(1.3293326), 5), round(Stats::gammaln(2.5), 5));
		$this->assertEquals(round(log(2), 5), round(Stats::gammaln(3), 5));
		$this->assertEquals(round(log(6), 5), round(Stats::gammaln(4), 5));
		$this->assertEquals(round(log(24), 5), round(Stats::gammaln(5), 5));
		$this->assertEquals(round(log(120), 4), round(Stats::gammaln(6), 4));
	}

	public function test_igamma() {
		$this->assertEquals(1, round(Stats::igamma(1, false), 0));
		$this->assertEquals(2, round(Stats::igamma(1), 1));
		$this->assertEquals(2.5, round(Stats::igamma(1.3293326), 1));
		$this->assertEquals(3, round(Stats::igamma(2), 1));
		$this->assertEquals(4, round(Stats::igamma(6), 2));
		$this->assertEquals(5, round(Stats::igamma(24), 1));
		$this->assertEquals(6, round(Stats::igamma(120), 2));
	}

	public function test_digamma() {
		$this->assertEquals(-0.57722, round(Stats::digamma(1), 5));
		$this->assertEquals(0.42278, round(Stats::digamma(2), 5));
		$this->assertEquals(0.92278, round(Stats::digamma(3), 5));
		$this->assertEquals(1.25612, round(Stats::digamma(4), 5));
		$this->assertEquals(1.38887, round(Stats::digamma(4.5), 5));
		$this->assertEquals(1.50612, round(Stats::digamma(5), 5));
	}

	public function test_lambert() {
		$this->assertEquals(0, round(Stats::lambert(0), 6));
		$this->assertEquals(0.567143, round(Stats::lambert(1), 6));
		$this->assertEquals(0.852606, round(Stats::lambert(2), 6));
		$this->assertEquals(1.049909, round(Stats::lambert(3), 6));
		$this->assertEquals(1.267238, round(Stats::lambert(4.5), 6));
		$this->assertEquals(1.326725, round(Stats::lambert(5), 6));
	}

	public function test_lowerGamma() {
		$this->assertEquals(0.16060, round(Stats::lowerGamma(3, 1), 5));
		$this->assertEquals(0.64665, round(Stats::lowerGamma(3, 2), 5));
		$this->assertEquals(0.91237, round(Stats::lowerGamma(3, 2.5), 5));
		$this->assertEquals(400.07089, round(Stats::lowerGamma(10, 3), 5));
		$this->assertEquals(2951.02827, round(Stats::lowerGamma(10, 4), 5));
		$this->assertEquals(11549.76544, round(Stats::lowerGamma(10, 5), 5));
		$this->assertEquals(30454.34729, round(Stats::lowerGamma(10, 6), 5));
	}
	
	public function test_ilowerGamma() {
		$this->assertEquals(1, round(Stats::ilowerGamma(3, 0.16060), 5));
		$this->assertEquals(2, round(Stats::ilowerGamma(3, 0.64665), 5));
		$this->assertEquals(2.5, round(Stats::ilowerGamma(3, 0.91237), 5));
		$this->assertEquals(3, round(Stats::ilowerGamma(10, 400.07089), 5));
		$this->assertEquals(4, round(Stats::ilowerGamma(10, 2951.02827), 5));
		$this->assertEquals(5, round(Stats::ilowerGamma(10, 11549.76544), 5));
		$this->assertEquals(6, round(Stats::ilowerGamma(10, 30454.34729), 5));
	}
	
	public function test_upperGamma() {
		$this->assertEquals(1.83940, round(Stats::upperGamma(3, 1), 5));
		$this->assertEquals(1.35335, round(Stats::upperGamma(3, 2), 5));
		$this->assertEquals(1.08763, round(Stats::upperGamma(3, 2.5), 5));
		$this->assertEquals(362479.92911, round(Stats::upperGamma(10, 3), 5));
		$this->assertEquals(359928.97173, round(Stats::upperGamma(10, 4), 5));
		$this->assertEquals(351330.23456, round(Stats::upperGamma(10, 5), 5));
		$this->assertEquals(332425.65271, round(Stats::upperGamma(10, 6), 5));
	}

	public function test_beta() {
		$this->assertEquals(1, round(Stats::beta(1, 1), 2));
		$this->assertEquals(0.5, round(Stats::beta(1, 2), 2));
		$this->assertEquals(0.5, round(Stats::beta(2, 1), 2));
		$this->assertEquals(0.0015873, round(Stats::beta(5, 5), 7));
		$this->assertEquals(0.0002525, round(Stats::beta(5, 8), 7));
	}

	public function test_regularizedIncompleteBeta() {
		$this->assertEquals(0.25, round(Stats::regularizedIncompleteBeta(1, 1, 0.25), 5));
		$this->assertEquals(0.43750, round(Stats::regularizedIncompleteBeta(1, 2, 0.25), 5));
		$this->assertEquals(0.06250, round(Stats::regularizedIncompleteBeta(2, 1, 0.25), 5));
		$this->assertEquals(0.73343, round(Stats::regularizedIncompleteBeta(5, 5, 0.6), 5));
		$this->assertEquals(0.94269, round(Stats::regularizedIncompleteBeta(5, 8, 0.6), 5));
	}

	public function test_iregularizedIncompleteBeta() {
		$this->assertEquals(0.25, round(Stats::iregularizedIncompleteBeta(1, 1, 0.25), 5));
		$this->assertEquals(0.25, round(Stats::iregularizedIncompleteBeta(1, 2, 0.43750), 5));
		$this->assertEquals(0.25, round(Stats::iregularizedIncompleteBeta(2, 1, 0.06250), 5));
		$this->assertEquals(0.6, round(Stats::iregularizedIncompleteBeta(5, 5, 0.73343), 5));
		$this->assertEquals(0.6, round(Stats::iregularizedIncompleteBeta(5, 8, 0.94269), 5));
	}

	public function test_permutations() {
		$this->assertEquals(1, Stats::permutations(1, 1));
		$this->assertEquals(2, Stats::permutations(2, 1));
		$this->assertEquals(12, Stats::permutations(4, 2));
		$this->assertEquals(120, Stats::permutations(5, 5));
		$this->assertEquals(6720, Stats::permutations(8, 5));
	}

	public function test_combinations() {
		$this->assertEquals(1, Stats::combinations(1, 1));
		$this->assertEquals(2, Stats::combinations(2, 1));
		$this->assertEquals(6, Stats::combinations(4, 2));
		$this->assertEquals(1, Stats::combinations(5, 5));
		$this->assertEquals(56, Stats::combinations(8, 5));
	}
}
?>
