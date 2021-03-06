<?php
include "NumUtilV5.php";
include "../v4/NumUtilV4.php";

/**
 * 这次总譔可以了吧，不，有点不放心，要是测试用例里的数据稍稍换一换呢？
 *
 * #################### MECE Tree ####################
 *参数输入正确的正常流程
 * 	零的个数大于1			@see TestCaseNumUtilV5::test_amountOfZeroGreaterThanOne()
 * 	零的个数等于1
 *		负数个数为偶数
 *			有正数		@see TestCaseNumUtilV5::test_amountOfZeroEqualsOne_amountOfNegativeIsEven_existsPositive()
 * 			无正数	   @see TestCaseNumUtilV5::test_amountOfZeroEqualsOne_amountOfNegativeIsEven_notExistsPositive()
 * 		负数个数为奇数
 * 			有正数		@see TestCaseNumUtilV5::test_amountOfZeroEqualsOne_amountOfNegativeIsOdd_existsPositive()
 *			无正数		@see TestCaseNumUtilV5::test_amountOfZeroEqualsOne_amountOfNegativeIsOdd_notExistsPositive()
 * 	零的个数小于1
 *		负数个数为偶数
 *			有正数		@see TestCaseNumUtilV5::test_amountOfZeroLessThanOne_amountOfNegativeIsEven_existsPositive()
 * 			无正数	   @see TestCaseNumUtilV5::test_amountOfZeroLessThanOne_amountOfNegativeIsEven_notExistsPositive()
 * 		负数个数为奇数
 * 			有正数		@see TestCaseNumUtilV5::test_amountOfZeroLessThanOne_amountOfNegativeIsOdd_existsPositive()
 *			无正数		@see TestCaseNumUtilV5::test_amountOfZeroLessThanOne_amountOfNegativeIsOdd_notExistsPositive()
 *
 *参数输入错误的异常流
 *	输入的参数不是数组		@see TestCaseNumUtilV5::test_inputIsNotArray()
 * 	是个数组
 * 		元素个数小于2个	@see TestCaseNumUtilV5::test_ArrayContainLessThanTwoInteger()
 *		元素大于等于2个
 * 			不全是整数	@see TestCaseNumUtilV5::test_ArrayContainNonInteger()
 *
 * #################### MECE Tree ####################
 */
class TestCaseNumUtilV5 extends PHPUnit_Framework_TestCase
{
	private $numUtil;
	public function setUp()
	{
		$this->numUtil = new NumUtilV4;
//		$this->numUtil = new NumUtilV5;
	}

	/**
	 * 零的个数大于1
	 * 本来根据根据负数个数奇偶性、正数有无可以分成四种情况
	 * 但这四种情况明显可以归并到这一种，因此不再分成四个条件来写
	 */
	public function test_amountOfZeroGreaterThanOne()
	{
		$arr = array_merge(
			$this->produceIntArray(rand(2, 10), self::INT_SIGN_ZERO),
			$this->produceIntArray(rand(10, 20), self::INT_SIGN_RAND)
		);
		$this->assertEquals(0, $this->numUtil->findMaxProd($arr));
	}

	/**
	 * 零的个数等于1 偶数个负数 有正数
	 */
	public function test_amountOfZeroEqualsOne_amountOfNegativeIsEven_existsPositive()
	{
		$this->execTest(200, array(0, -1, -2, 10, 5, 2));
	}

	/**
	 * 零的个数等于1 偶数个负数 无正数
	 */
	public function test_amountOfZeroEqualsOne_amountOfNegativeIsEven_notExistsPositive()
	{
		$this->execTest(100, array(0, -1, -2, -10, -5));
	}

	/**
	 * 零的个数等于1 奇数个负数 有正数
	 */
	public function test_amountOfZeroEqualsOne_amountOfNegativeIsOdd_existsPositive()
	{
		$arr = array_merge(
			$this->produceIntArray(11, self::INT_SIGN_NEGA),
			array(0),
			$this->produceIntArray(rand(1,10), self::INT_SIGN_POSI)
		);
		$this->assertEquals(0, $this->numUtil->findMaxProd($arr));
	}

	/**
	 * 零的个数等于1 奇数个负数 无正数
	 */
	public function test_amountOfZeroEqualsOne_amountOfNegativeIsOdd_notExistsPositive()
	{
		$arr = array_merge(
			$this->produceIntArray(11, self::INT_SIGN_NEGA),
			array(0)
		);
		$this->assertEquals(0, $this->numUtil->findMaxProd($arr));
	}

	/**
	 * 零的个数小于1 偶数个负数 有正数
	 */
	public function test_amountOfZeroLessThanOne_amountOfNegativeIsEven_existsPositive()
	{
		$this->execTest(100, array( -1, -2, -10, -5, 10));
	}

	/**
	 * 零的个数小于1 偶数个负数 无正数
	 */
	public function test_amountOfZeroLessThanOne_amountOfNegativeIsEven_notExistsPositive()
	{
		$this->execTest(-10, array( -1, -2, -1024, -5));
	}

	/**
	 * 零的个数小于1 奇数个负数 有正数
	 */
	public function test_amountOfZeroLessThanOne_amountOfNegativeIsOdd_existsPositive()
	{
		$this->execTest(200, array(-2, -10, -5, 4), self::INT_SIGN_POSI);
	}

	/**
	 * 零的个数小于1 奇数个负数 无正数
	 */
	public function test_amountOfZeroLessThanOne_amountOfNegativeIsOdd_notExistsPositive()
	{
		$this->execTest(50, array(-2, -10, -5), self::INT_SIGN_POSI);
	}

	public function test_inputIsNotArrayDataProvider()
	{
		return array(
			array(NULL),
			array(TRUE),
			array(1024),
			array(3.14),
			array("not an array"),
			array(new TestCaseNumUtilV5),
		);
	}

	/**
	 * 输入的参数不是数组
	 * @dataProvider test_inputIsNotArrayDataProvider
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function test_inputIsNotArray($arg)
	{
		$this->numUtil->findMaxProd($arg);
	}

	/**
	 * 数组元素个数小于2个
	 */
	public function test_ArrayContainLessThanTwoInteger()
	{
		$this->assertFalse($this->numUtil->findMaxProd(array(10)));
	}

	/**
	 * 数组元素不全是整数
	 */
	public function test_ArrayContainNonInteger()
	{
		$this->assertFalse($this->numUtil->findMaxProd(array(-2, TRUE, -5)));
	}

	const INT_SIGN_POSI = "positive";
	const INT_SIGN_NEGA = "negative";
	const INT_SIGN_ZERO = "zero";
	const INT_SIGN_RAND = "RAND";

	private function  produceIntArray($length, $sign)
	{
		$int_arr = array();
		switch($sign)
		{
			case self::INT_SIGN_POSI :
				for($i = 0; $i < $length; $i++)
				{
					$int_arr[$i] = rand(1, 99);
				}
				break;
			case self::INT_SIGN_NEGA :
				for($i = 0; $i < $length; $i++)
				{
					$int_arr[$i] = 0 - rand(1, 99);
				}
				break;
			case self::INT_SIGN_ZERO :
				for($i = 0; $i < $length; $i++)
				{
					$int_arr[$i] = 0;
				}
				break;
			case self::INT_SIGN_RAND :
				for($i = 0; $i < $length; $i++)
				{
					$int_arr[$i] = $i % 2 ? rand(1, 99) : 0 - rand(0, 99);
				}
				break;
		}
		return $int_arr;
	}

	private function execTest($exp, array $arr, $sign = self::INT_SIGN_NEGA)
	{
		$randInt = self::INT_SIGN_POSI == $sign ? rand(1, 100) : 0 - rand(1, 99);
		$arr[] = $randInt;
		$arr[] = $randInt;
		shuffle($arr);
		$this->assertEquals($exp * $randInt * $randInt, $this->numUtil->findMaxProd($arr));
	}
}