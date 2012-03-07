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
 * F class
 * 
 * Represents the F distribution, which is frequently used as the null
 * distribution of a test statistic, such as the analysis of variance.
 *
 * For more information, see: http://en.wikipedia.org/wiki/F_distribution
 */
class F extends ProbabilityDistribution {
	private $d1;
	private $d2;
	
	/**
	 * Constructor function
	 * 
	 * @param int $d1 Degrees of freedom
	 * @param int $d2 Degrees of freedom
	 */
	public function __construct($d1 = 1, $d2 = 1) {
		$this->d1 = $d1;
		$this->d2 = $d2;
	}
	
	/**
	 * Returns a random float between $d1 and $d1 plus $d2
	 * 
	 * @return float The random variate.
	 */
	public function rvs() {
		return self::getRvs($this->d1, $this->d2);
	}
	
	/**
	 * Returns the probability distribution function
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function pdf($x) {
		return self::getPdf($x, $this->d1, $this->d2);
	}
	
	/**
	 * Returns the cumulative distribution function, the probability of getting the test value or something below it
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function cdf($x) {
		return self::getCdf($x, $this->d1, $this->d2);
	}
	
	/**
	 * Returns the survival function, the probability of getting the test value or something above it
	 * 
	 * @param float $x The test value
	 * @return float The probability
	 */
	public function sf($x) {
		return self::getSf($x, $this->d1, $this->d2);
	}
	
	/**
	 * Returns the percent-point function, the inverse of the cdf
	 * 
	 * @param float $x The test value
	 * @return float The value that gives a cdf of $x
	 */
	public function ppf($x) {
		return self::getPpf($x, $this->d1, $this->d2);
	}
	
	/**
	 * Returns the inverse survival function, the inverse of the sf
	 * 
	 * @param float $x The test value
	 * @return float The value that gives an sf of $x
	 */
	public function isf($x) {
		return self::getIsf($x, $this->d1, $this->d2);
	}
	
	/**
	 * Returns the moments of the distribution
	 * 
	 * @param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
	 * @return type array A dictionary containing the first four moments of the distribution
	 */
	public function stats($moments = 'mv') {
		return self::getStats($moments, $this->d1, $this->d2);
	}
	
	/**
	 * Returns a random float between $d1 and $d1 plus $d2
	 * 
	 * @param float $d1 Degrees of freedom 1. Default 1.0
	 * @param float $d2 Degrees of freedom 2. Default 1.0
	 * @return float The random variate.
	 * @static
	 */
	public static function getRvs($d1 = 1, $d2 = 1) {
		$x = \PHPStats\ProbabilityDistribution\ChiSquare::getRvs($d1);
		$y = \PHPStats\ProbabilityDistribution\ChiSquare::getRvs($d2);
		return ($x / $d1) / ($y / $d2);
	}
	
	/**
	 * Returns the probability distribution function
	 * 
	 * @param float $x The test value
	 * @param float $d1 Degrees of freedom 1. Default 1.0
	 * @param float $d2 Degrees of freedom 2. Default 1.0
	 * @return float The probability
	 * @static
	 */
	public static function getPdf($x, $d1 = 1, $d2 = 1) {
		return pow((pow($d1 * $x, $d1) * pow($d2, $d2))/(pow($d1 * $x + $d2, $d1 + $d2)), 0.5)/($x * \PHPStats\Stats::beta($d1 / 2, $d2 / 2));
	}
	
	/**
	 * Returns the cumulative distribution function, the probability of getting the test value or something below it
	 * 
	 * @param float $x The test value
	 * @param float $d1 Degrees of freedom 1. Default 1.0
	 * @param float $d2 Degrees of freedom 2. Default 1.0
	 * @return float The probability
	 * @static
	 */
	public static function getCdf($x, $d1 = 1, $d2 = 1) {
		return \PHPStats\Stats::regularizedIncompleteBeta($d1 / 2, $d2 / 2, ($d1 * $x)/($d1 * $x + $d2));
	}
	
	/**
	 * Returns the survival function, the probability of getting the test value or something above it
	 * 
	 * @param float $x The test value
	 * @param float $d1 Degrees of freedom 1. Default 1.0
	 * @param float $d2 Degrees of freedom 2. Default 1.0
	 * @return float The probability
	 * @static
	 */
	public static function getSf($x, $d1 = 1, $d2 = 1) {
		return 1.0 - self::getCdf($x, $d1, $d2);
	}
	
	/**
	 * Returns the percent-point function, the inverse of the cdf
	 * 
	 * @param float $x The test value
	 * @param float $d1 Degrees of freedom 1. Default 1.0
	 * @param float $d2 Degrees of freedom 2. Default 1.0
	 * @return float The value that gives a cdf of $x
	 * @static
	 */
	public static function getPpf($x, $d1 = 1, $d2 = 1) {
		$iY = \PHPStats\Stats::iregularizedIncompleteBeta($d1/2, $d2/2, $x);
		return -($d2*$iY) / ($d1 * ($iY - 1));
	}
	
	/**
	 * Returns the inverse survival function, the inverse of the sf
	 * 
	 * @param float $x The test value
	 * @param float $d1 Degrees of freedom 1. Default 1.0
	 * @param float $d2 Degrees of freedom 2. Default 1.0
	 * @return float The value that gives an sf of $x
	 * @static
	 */
	public static function getIsf($x, $d1 = 1, $d2 = 1) {
		return self::getPpf(1.0 - $x, $d1, $d2);
	}
	
	/**
	 * Returns the moments of the distribution
	 * 
	 * @param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
	 * @param float $d1 Degrees of freedom 1. Default 1.0
	 * @param float $d2 Degrees of freedom 2. Default 1.0
	 * @return type array A dictionary containing the first four moments of the distribution
	 * @static
	 */
	public static function getStats($moments = 'mv', $d1 = 1, $d2 = 1) {
		$return = array();
		
		if (strpos($moments, 'm') !== FALSE) {
			if ($d2 > 2) $return['mean'] = $d2 / ($d2 - 2);
			else $return['mean'] = NAN;
		}
		if (strpos($moments, 'v') !== FALSE) {
			if ($d2 > 4) $return['variance'] = 2 * pow($d2, 2) * ($d1 + $d2 - 2)/($d1 * pow($d2 - 2, 2) * ($d2 - 4));
			else $return['variance'] = NAN;
		}
		if (strpos($moments, 's') !== FALSE) {
			if ($d2 > 6) $return['skew'] = (2 * $d1 + $d2 -2) * pow(8 * ($d2 - 4), 0.5) / (($d2 - 6) * pow($d1 * ($d1 + $d2 - 2), 0.5));
			else $return['skew'] = NAN;
		}
		if (strpos($moments, 'k') !== FALSE) {
			if ($d2 > 8) $return['kurtosis'] = 12 * ($d1 * (5 * $d2 - 22) * ($d1 + $d2 - 2) + ($d2 - 4) * pow($d2 - 2, 2)) / ($d1 * ($d2 - 6) * ($d2 - 8) * ($d1 + $d2 - 2));
			else $return['kurtosis'] = NAN;
		}
		
		return $return;
	}
}
