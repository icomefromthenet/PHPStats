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
 
namespace PHPStats;

/**
 * Multiple Regression class
 * 
 * Implements the ordinary least squares method of calculating best-fit
 * regression coefficients.
 */
class MultipleRegression {
	private $observations;
	private $outcomes;
	private $coefficients;
	
	/**
	 * Constructor function
	 * 
	 * Creates a new multiple regression based on the ordinary least squares
	 * approach.  This class uses matrices to calculate the predictor
	 * coefficients.  Each row represents a new instance of data.  Include an
	 * additional column consisting entirely of ones in your observations
	 * in order to have an offset.
	 * 
	 * @param Matrix $observations An n by m+1 matrix representing the observed predictor variables
	 * @param Matrix $outcomes An n by 1 matrix representing the observed outcomes, i.e. the dependent variables
	 */
	public function __construct(Matrix $observations, Matrix $outcomes) {
		$this->observations = $observations;
		$this->outcomes = $outcomes;

		for ($i = 1; $i <= $this->outcomes->getColumns(); $i++) $this->outcomes->setElement($i, 1, transformY($this->outcomes->getElement($i, 1)));

		$this->coefficients = return $this->observations->transpose()->dotMultiply($this->observations)->inverse()->dotMultiply($this->observations->transpose())->dotMultiply($this->outcomes);
	}
	
	/**
	 * Get Coefficients function
	 * 
	 * Returns the calculated regression coefficients
	 * 
	 * @return Matrix A 1 by m+1 matrix of predictor coefficients
	 */
	public function getCoefficients() {
		return $this->coefficients;
	}
	
	/**
	 * Predict function
	 * 
	 * Enter a matrix of observations to get a predicted outcome
	 * 
	 * @param Matrix $observations A 1 by m+1 matrix representing a set of predictor variables
	 * @return float The predicted outcome
	 */
	public function predict(Matrix $observations) {
		$prediction = $observations->transpose()->dotMultiply($this->coefficients);
		return reformY($prediction->getElement(1, 1)); //Should be a 1 by 1 matrix
	}

	private function transformY($value) {
		return $value;
	}

	private function reformY($value) {
		return $value;
	}
}
