<?php
require_once('lib/Stats.php');
require_once('lib/Matrix.php');
require_once('lib/RegressionModel/MultipleRegression.php');

use \PHPStats\RegressionModel\MultipleRegression as MultipleRegression;

class MultipleRegressionTest extends PHPUnit_Framework_TestCase {
	private $regressionModel;

	public function __construct() {
		$observations = new Matrix('[]');
		$outcomes = array('[]');

		$this->regressionModel = new MultipleRegression($observations, $outcomes);
	}
}
?>
