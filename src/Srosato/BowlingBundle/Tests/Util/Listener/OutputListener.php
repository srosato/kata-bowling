<?php

namespace Srosato\BowlingBundle\Tests\Util\Listener;

use Majisti\UtilsBundle\Test\MinkTestCase;

class OutputListener implements \PHPUnit_Framework_TestListener
{
    /**
     * An error occurred.
     *
     * @param  \PHPUnit_Framework_Test $test
     * @param  \Exception              $e
     * @param  float                  $time
     */
    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        // TODO: Implement addError() method.
    }

    /**
     * A failure occurred.
     *
     * @param  \PHPUnit_Framework_Test                 $test
     * @param  \PHPUnit_Framework_AssertionFailedError $e
     * @param  float                                  $time
     */
    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        /* @var $test MinkTestCase */
        $session = $test->getSession();

        print $session->getPage()->getContent();
    }

    /**
     * Incomplete test.
     *
     * @param  \PHPUnit_Framework_Test $test
     * @param  \Exception              $e
     * @param  float                  $time
     */
    public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        // TODO: Implement addIncompleteTest() method.
    }

    /**
     * Skipped test.
     *
     * @param  \PHPUnit_Framework_Test $test
     * @param  \Exception              $e
     * @param  float                  $time
     * @since  Method available since Release 3.0.0
     */
    public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        // TODO: Implement addSkippedTest() method.
    }

    /**
     * A test suite started.
     *
     * @param  \PHPUnit_Framework_TestSuite $suite
     * @since  Method available since Release 2.2.0
     */
    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        // TODO: Implement startTestSuite() method.
    }

    /**
     * A test suite ended.
     *
     * @param  \PHPUnit_Framework_TestSuite $suite
     * @since  Method available since Release 2.2.0
     */
    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        // TODO: Implement endTestSuite() method.
    }

    /**
     * A test started.
     *
     * @param  \PHPUnit_Framework_Test $test
     */
    public function startTest(\PHPUnit_Framework_Test $test)
    {
    }

    /**
     * A test ended.
     *
     * @param  \PHPUnit_Framework_Test $test
     * @param  float                  $time
     */
    public function endTest(\PHPUnit_Framework_Test $test, $time)
    {
        // TODO: Implement endTest() method.
    }
}