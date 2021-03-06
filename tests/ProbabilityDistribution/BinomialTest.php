<?php
namespace PHPStats\Tests\ProbabilityDistribution;

use PHPStats\PDistribution\Binomial as Binomial,
PHPStats\PCalculator\Binomial as BinomialCalculator,
PHPStats\Tests\Base\PDTest;


class BinomialTest extends PDTest
{
    
    /**
      *  @var PHPStats\PDistribution\Binomial
      */
    private $testObject;

    public function __construct()
    {
	parent::__construct();
	
	$bioCal = new BinomialCalculator($this->randomGenerator,$this->basicStats);
	$this->testObject = new Binomial(0.5, 5,$bioCal);
    }

    public function testRvs()
    {
	$variates = 10000;
	$max_tested = 5;
	$expected = array();
	$observed = array();

	for ($i = 0; $i <= $max_tested; $i++) {
    	    $expected[] = 0;
    	    $observed[] = 0;
	 }
	    
	for ($i = 0; $i < $variates; $i++) {
    	    
	    $variate = $this->testObject->rvs();
    	    
    	    if ($variate < $max_tested) {
		$observed[$variate]++;
    	    }
    	    else {
		$observed[$max_tested]++;
    	    }
	}
	    
        for ($i = 0; $i < $max_tested; $i++) {
	    $expected[$i] = $variates * $this->testObject->pmf($i);
        }
	    
	$expected[$max_tested] = $variates * $this->testObject->sf($max_tested - 1);
	    
	$this->assertGreaterThanOrEqual(0.01, $this->statisticalTests->chiSquareTest($observed, $expected, $max_tested - 1));
	$this->assertLessThanOrEqual(0.99, $this->statisticalTests->chiSquareTest($observed, $expected, $max_tested - 1));
	
    }

    public function test_pmf()
    {
	$this->assertEquals(0.3125, $this->testObject->pmf(2));
    }

    public function testCdf()
    {
	$this->assertEquals(0.5, $this->testObject->cdf(2));
    }

    public function testSF()
    {
	$this->assertEquals(0.5, $this->testObject->sf(2));
    }

    public function testPpf()
    {
	$this->assertEquals(2, $this->testObject->ppf(0.5));
    }

    public function testIsf()
    {
	$this->assertEquals(2, $this->testObject->isf(0.5));
    }

    public function testStats()
    {
	$summaryStats = $this->testObject->stats('mvsk');

	$this->assertEquals(2.5, $summaryStats['mean']);
	$this->assertEquals(1.25, $summaryStats['variance']);
	$this->assertEquals(0, $summaryStats['skew']);
	$this->assertEquals(-0.4, $summaryStats['kurtosis']);
    }
}
/* End of File */
