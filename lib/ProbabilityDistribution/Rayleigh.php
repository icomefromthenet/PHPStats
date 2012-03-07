<?php
/**
 * PHP Statistics Library
 *
 * Copyright (C) 2011-2012 Michael Cordingley <mcordingley@gmail.com>
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
 * Rayleigh class
 * 
 * Represents the Rayleigh distribution, which is a specialization of the
 * Weibull distribution.  The Rayleigh distribution represents the absolute
 * magnitude of the combination of two orthogonal, normally-distributed and
 * iid directional components.
 * 
 * For more information, see: http://en.wikipedia.org/wiki/Rayleigh_distribution
 */
class Rayleigh extends ProbabilityDistribution {
	private $sigma;
	
	/**
	 * Constructor function
	 * 
	 * @param float $sigma The scale parameter
	 */
	public function __construct($sigma = 1) {
		$this->sigma = $sigma;
	}
	
	/**
	 * Returns a random float
	 * 
	 * @return float The random variate.
	 */
	public function rvs() {
		return self::getRvs($this->sigma);
	}
	
	/**
	 * Returns the probability distribution function
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function pdf($x) {
		return self::getPdf($x, $this->sigma);
	}
	
	/**
	 * Returns the cumulative distribution function, the probability of getting the test value or something below it
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function cdf($x) {
		return self::getCdf($x, $this->sigma);
	}
	
	/**
	 * Returns the survival function, the probability of getting the test value or something above it
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function sf($x) {
		return self::getSf($x, $this->sigma);
	}
	
	/**
	 * Returns the percent-point function, the inverse of the cdf
	 * 
	 * @param float $x The test value
	 * @return float The value that gives a cdf of $x
	 */
	public function ppf($x) {
		return self::getPpf($x, $this->sigma);
	}
	
	/**
	 * Returns the inverse survival function, the inverse of the sf
	 * 
	 * @param float $x The test value
	 * @return float The value that gives an sf of $x
	 */
	public function isf($x) {
		return self::getIsf($x, $this->sigma);
	}
	
	/**
	 * Returns the moments of the distribution
	 * 
	 * @param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
	 * @return type array A dictionary containing the first four moments of the distribution
	 */
	public function stats($moments = 'mv') {
		return self::getStats($moments, $this->sigma);
	}
	
	private static function convertSigmaToLambda($sigma) {
		return $sigma * M_SQRT2;
	}
	
	/**
	 * Returns a Rayleigh-distributed random variable
	 * 
	 * @param float $sigma The scale parameter
	 * @return float The random variate
	 * @static
	 */
	public static function getRvs($sigma = 1) {
		$u = 0;
		while ($u == 0) {
			$u = self::randFloat();
		}

		return $sigma*sqrt(-2*log($u));
	}
	
	/**
	 * Returns the probability distribution function
	 * 
	 * @param float $x The test value
	 * @param float $sigma The scale parameter
	 * @return float The probability
	 * @static
	 */
	public static function getPdf($x, $sigma = 1) {
		return $x * exp( -pow($x, 2) / (2*pow($sigma, 2)) ) / pow($sigma, 2);
	}
	
	/**
	 * Returns the cumulative distribution function, the probability of getting the test value or something below it
	 * 
	 * @param float $x The test value
	 * @param float $sigma The scale parameter
	 * @return float The probability
	 * @static
	 */
	public static function getCdf($x, $sigma = 1) {
		return 1 - exp( -pow($x, 2)/(2*pow($sigma, 2)) );
	}
	
	/**
	 * Returns the survival function, the probability of getting the test value or something above it
	 * 
	 * @param float $x The test value
	 * @param float $sigma The scale parameter
	 * @return float The probability
	 * @static
	 */
	public static function getSf($x, $sigma = 1) {
		return 1.0 - self::getCdf($x, $sigma);
	}
	
	/**
	 * Returns the percent-point function, the inverse of the cdf
	 * 
	 * @param float $x The test value
	 * @param float $sigma The scale parameter
	 * @return float The value that gives a cdf of $x
	 * @static
	 */
	public static function getPpf($x, $sigma = 1) {
		$lambda = self::convertSigmaToLambda($sigma);
		return \PHPStats\ProbabilityDistribution\Weibull::getPpf($x, $lambda, 2);
	}
	
	/**
	 * Returns the inverse survival function, the inverse of the sf
	 * 
	 * @param float $x The test value
	 * @param float $sigma The scale parameter
	 * @return float The value that gives an sf of $x
	 * @static
	 */
	public static function getIsf($x, $sigma = 1) {
		return self::getPpf(1.0 - $x, $sigma);
	}
	
	/**
	 * Returns the moments of the distribution
	 * 
	 * @param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
	 * @param float $sigma The scale parameter
	 * @return type array A dictionary containing the first four moments of the distribution
	 * @static
	 */
	public static function getStats($moments = 'mv', $sigma = 1) {
		$lambda = self::convertSigmaToLambda($sigma);
		return \PHPStats\ProbabilityDistribution\Weibull::getStats($moments, $lambda, 2);
	}
}
