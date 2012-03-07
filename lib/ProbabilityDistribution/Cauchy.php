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
 * Cauchy class
 * 
 * Represents the Cauchy distribution, also known as the Lorentz distribution.
 * 
 * For more information, see: http://en.wikipedia.org/wiki/Cauchy_distribution
 */
class Cauchy extends ProbabilityDistribution {
	private $mu;
	private $gamma;
	
	/**
	 * Constructor function
	 * 
	 * @param float $mu The location parameter
	 * @param float $gamma The scale parameter
	 */
	public function __construct($mu = 0.0, $gamma = 1.0) {
		$this->mu = $mu;
		$this->gamma = $gamma;
	}
	
	/**
	 * Returns a random float between $mu and $mu plus $gamma
	 * 
	 * @return float The random variate.
	 */
	public function rvs() {
		return self::getRvs($this->mu, $this->gamma);
	}
	
	/**
	 * Returns the probability distribution function
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function pdf($x) {
		return self::getPdf($x, $this->mu, $this->gamma);
	}
	
	/**
	 * Returns the cumulative distribution function, the probability of getting the test value or something below it
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function cdf($x) {
		return self::getCdf($x, $this->mu, $this->gamma);
	}
	
	/**
	 * Returns the survival function, the probability of getting the test value or something above it
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function sf($x) {
		return self::getSf($x, $this->mu, $this->gamma);
	}
	
	/**
	 * Returns the percent-point function, the inverse of the cdf
	 * 
	 * @param float $x The test value
	 * @return float The value that gives a cdf of $x
	 */
	public function ppf($x) {
		return self::getPpf($x, $this->mu, $this->gamma);
	}
	
	/**
	 * Returns the inverse survival function, the inverse of the sf
	 * 
	 * @param float $x The test value
	 * @return float The value that gives an sf of $x
	 */
	public function isf($x) {
		return self::getIsf($x, $this->mu, $this->gamma);
	}
	
	/**
	 * Returns the moments of the distribution
	 * 
	 * @param string $moments Which moments to compute. m for mean, v for gamma, s for skew, k for kurtosis.  Default 'mv'
	 * @return type array A dictionary containing the first four moments of the distribution
	 */
	public function stats($moments = 'mv') {
		return self::getStats($moments, $this->mu, $this->gamma);
	}
	
	/**
	 * Returns a Cauchy-distributed random float
	 * 
	 * @param float $mu The location parameter
	 * @param float $gamma The scale parameter
	 * @return float The random variate.
	 * @static
	 */
	public static function getRvs($mu = 0.0, $gamma = 1.0) {
		$u = \PHPStats\ProbabilityDistribution\Normal::getRvs(0, 1);
		$v = \PHPStats\ProbabilityDistribution\Normal::getRvs(0, 1);
		return $gamma * ($u/$v) + $mu;
	}
	
	/**
	 * Returns the probability distribution function
	 * 
	 * @param float $x The test value
	 * @param float $mu The location parameter
	 * @param float $gamma The scale parameter
	 * @return float The probability
	 * @static
	 */
	public static function getPdf($x, $mu = 0.0, $gamma = 1.0) {
		return 1/(M_PI * $gamma * (1 + pow(($x - $mu)/$gamma, 2)));
	}
	
	/**
	 * Returns the cumulative distribution function, the probability of getting the test value or something below it
	 * 
	 * @param float $x The test value
	 * @param float $mu The location parameter
	 * @param float $gamma The scale parameter
	 * @return float The probability
	 * @static
	 */
	public static function getCdf($x, $mu = 0.0, $gamma = 1.0) {
		return M_1_PI * atan(($x - $mu)/$gamma) + 0.5;
	}
	
	/**
	 * Returns the survival function, the probability of getting the test value or something above it
	 * 
	 * @param float $x The test value
	 * @param float $mu The location parameter
	 * @param float $gamma The scale parameter
	 * @return float The probability
	 * @static
	 */
	public static function getSf($x, $mu = 0.0, $gamma = 1.0) {
		return 1.0 - self::getCdf($x, $mu, $gamma);
	}
	
	/**
	 * Returns the percent-point function, the inverse of the cdf
	 * 
	 * @param float $x The test value
	 * @param float $mu The location parameter
	 * @param float $gamma The scale parameter
	 * @return float The value that gives a cdf of $x
	 * @static
	 */
	public static function getPpf($x, $mu = 0.0, $gamma = 1.0) {
		return $gamma * tan(M_PI * ($x - 0.5)) + $mu;
	}
	
	/**
	 * Returns the inverse survival function, the inverse of the sf
	 * 
	 * @param float $x The test value
	 * @param float $mu The location parameter
	 * @param float $gamma The scale parameter
	 * @return float The value that gives an sf of $x
	 * @static
	 */
	public static function getIsf($x, $mu = 0.0, $gamma = 1.0) {
		return self::getPpf(1.0 - $x, $mu, $gamma);
	}
	
	/**
	 * Returns the moments of the distribution
	 * 
	 * @param string $moments Which moments to compute. m for mean, v for gamma, s for skew, k for kurtosis.  Default 'mv'
	 * @param float $mu The location parameter
	 * @param float $gamma The scale parameter
	 * @return type array A dictionary containing the first four moments of the distribution
	 * @static
	 */
	public static function getStats($moments = 'mv', $mu = 0.0, $gamma = 1.0) {
		$return = array();
		
		if (strpos($moments, 'm') !== FALSE) $return['mean'] = NAN;
		if (strpos($moments, 'v') !== FALSE) $return['variance'] = NAN;
		if (strpos($moments, 's') !== FALSE) $return['skew'] = NAN;
		if (strpos($moments, 'k') !== FALSE) $return['kurtosis'] = NAN;
		
		return $return;
	}
}
