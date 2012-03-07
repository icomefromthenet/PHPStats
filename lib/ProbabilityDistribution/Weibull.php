<?php
/**
 * PHP Statistics Library
 *
 * Copyright (C) 2011-2012 Michael Cordingley<Michael.Cordingley@gmail.com>
 * 
 * This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Library General Public License as published
 * by the Free Software Foundation; either version 3 of the License, or 
 * (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Library General Public
 * License for more details.
 * 
 * You should have received a copy of the GNU Library General Public License
 * along with this library; if not, write to the Free Software Foundation, 
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
 * 
 * LGPL Version 3
 *
 * @package PHPStats
 */
 
namespace PHPStats\ProbabilityDistribution;

/**
 * Weibull class
 * 
 * Represents the Weibull distribution, which is frequently used to model
 * failure rates.  In essence, it is the exponential distribution, but with
 * a rate that increases or decreases linearly over time.  A k of one indicates
 * a constant failure rate, whereas less than one indicates a decreasing
 * failure rate and a higher k indicates an increasing failure rate.
 * 
 * For more information, see: http://en.wikipedia.org/wiki/Weibull_distribution
 */
class Weibull extends ProbabilityDistribution {
	private $lambda;
	private $k;
	
	/**
	 * Constructor function
	 * 
	 * @param float $lambda The scale parameter
	 * @param float $k The shape parameter
	 */
	public function __construct($lambda = 1, $k = 1) {
		$this->lambda = $lambda;
		$this->k = $k;
	}
	
	/**
	 * Returns a random float between $lambda and $lambda plus $k
	 * 
	 * @return float The random variate.
	 */
	public function rvs() {
		return self::getRvs($this->lambda, $this->k);
	}
	
	/**
	 * Returns the probability distribution function
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function pdf($x) {
		return self::getPdf($x, $this->lambda, $this->k);
	}
	
	/**
	 * Returns the cumulative distribution function, the probability of getting the test value or something below it
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function cdf($x) {
		return self::getCdf($x, $this->lambda, $this->k);
	}
	
	/**
	 * Returns the survival function, the probability of getting the test value or something above it
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function sf($x) {
		return self::getSf($x, $this->lambda, $this->k);
	}
	
	/**
	 * Returns the percent-point function, the inverse of the cdf
	 * 
	 * @param float $x The test value
	 * @return float The value that gives a cdf of $x
	 */
	public function ppf($x) {
		return self::getPpf($x, $this->lambda, $this->k);
	}
	
	/**
	 * Returns the inverse survival function, the inverse of the sf
	 * 
	 * @param float $x The test value
	 * @return float The value that gives an sf of $x
	 */
	public function isf($x) {
		return self::getIsf($x, $this->lambda, $this->k);
	}
	
	/**
	 * Returns the moments of the distribution
	 * 
	 * @param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
	 * @return type array A dictionary containing the first four moments of the distribution
	 */
	public function stats($moments = 'mv') {
		return self::getStats($moments, $this->lambda, $this->k);
	}
	
	/**
	 * Returns a random float between $lambda and $lambda plus $k
	 * 
	 * @param float $lambda The scale parameter. Default 1.0
	 * @param float $k The shape parameter. Default 1.0
	 * @return float The random variate.
	 * @static
	 */
	public static function getRvs($lambda = 1, $k = 1) {
		$e = \PHPStats\ProbabilityDistribution\Exponential::getRvs(1);
		return ($e == 0)? 0 : $lambda * pow($e, 1/$k);
	}
	
	/**
	 * Returns the probability distribution function
	 * 
	 * @param float $x The test value
	 * @param float $lambda The scale parameter. Default 1.0
	 * @param float $k The shape parameter. Default 1.0
	 * @return float The probability
	 * @static
	 */
	public static function getPdf($x, $lambda = 1, $k = 1) {
		if ($x >= 0) return ($k / $lambda) * pow($x / $lambda, $k - 1)*exp(-pow($x / $lambda, $k));
		else return 0.0;
	}
	
	/**
	 * Returns the cumulative distribution function, the probability of getting the test value or something below it
	 * 
	 * @param float $x The test value
	 * @param float $lambda The scale parameter. Default 1.0
	 * @param float $k The shape parameter. Default 1.0
	 * @return float The probability
	 * @static
	 */
	public static function getCdf($x, $lambda = 1, $k = 1) {
		return 1 - exp(-pow($x / $lambda, $k));
	}
	
	/**
	 * Returns the survival function, the probability of getting the test value or something above it
	 * 
	 * @param float $x The test value
	 * @param float $lambda The scale parameter. Default 1.0
	 * @param float $k The shape parameter. Default 1.0
	 * @return float The probability
	 * @static
	 */
	public static function getSf($x, $lambda = 1, $k = 1) {
		return 1.0 - self::getCdf($x, $lambda, $k);
	}
	
	/**
	 * Returns the percent-point function, the inverse of the cdf
	 * 
	 * @param float $x The test value
	 * @param float $lambda The scale parameter. Default 1.0
	 * @param float $k The shape parameter. Default 1.0
	 * @return float The value that gives a cdf of $x
	 * @static
	 */
	public static function getPpf($x, $lambda = 1, $k = 1) {
		return $lambda * pow(-log(1 - $x), 1 / $k);
	}
	
	/**
	 * Returns the inverse survival function, the inverse of the sf
	 * 
	 * @param float $x The test value
	 * @param float $lambda The scale parameter. Default 1.0
	 * @param float $k The shape parameter. Default 1.0
	 * @return float The value that gives an sf of $x
	 * @static
	 */
	public static function getIsf($x, $lambda = 1, $k = 1) {
		return self::getPpf(1.0 - $x, $lambda, $k);
	}
	
	/**
	 * Returns the moments of the distribution
	 * 
	 * @param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
	 * @param float $lambda The scale parameter. Default 1.0
	 * @param float $k The shape parameter. Default 1.0
	 * @return type array A dictionary containing the first four moments of the distribution
	 * @static
	 */
	public static function getStats($moments = 'mv', $lambda = 1, $k = 1) {
		$return = array();
		
		if (strpos($moments, 'm') !== FALSE) $return['mean'] = $lambda*\PHPStats\Stats::gamma(1 + 1/$k);
		if (strpos($moments, 'v') !== FALSE) $return['variance'] = pow($lambda, 2) * \PHPStats\Stats::gamma(1 + 2/$k) - pow($return['mean'], 2);
		if (strpos($moments, 's') !== FALSE) $return['skew'] = (\PHPStats\Stats::gamma(1 + 3/$k) * pow($lambda, 3) - 3*$return['mean']*$return['variance'] - pow($return['mean'], 3))/pow($return['variance'], 1.5);
		if (strpos($moments, 'k') !== FALSE) $return['kurtosis'] = (-6 * pow(\PHPStats\Stats::gamma(1 + 1/$k), 4) + 12 * pow(\PHPStats\Stats::gamma(1 + 1/$k), 2) * \PHPStats\Stats::gamma(1 + 2/$k) - 3 * pow(\PHPStats\Stats::gamma(1 + 2/$k), 2) - 4 * \PHPStats\Stats::gamma(1 + 1/$k) * \PHPStats\Stats::gamma(1 + 3/$k) + \PHPStats\Stats::gamma(1 + 4/$k))/pow(\PHPStats\Stats::gamma(1 + 2/$k) - pow(\PHPStats\Stats::gamma(1 + 1/$k), 2), 2);
		
		return $return;
	}
}
