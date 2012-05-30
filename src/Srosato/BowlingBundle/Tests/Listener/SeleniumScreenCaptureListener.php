<?php

namespace Srosato\BowlingBundle\Tests\Listener;

class SeleniumScreenCaptureListener implements \PHPUnit_Framework_TestListener
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

    private function getScreenshotNameFromTrace(array $trace)
    {
        $name = '';
        foreach( $trace as $t ) {
            if( isset($t['file']) && false !== stripos($t['file'], 'phpunit') ) {
                continue;
            }

            if( strlen($name) > 0 ) {
                $name .= '_';
            }

            if( isset($t['file']) ) {
                $name .= basename($t['file']) . '@' . $t['line'];
            } else {
                $name .= $t['function'];
            }
        }

        if( strlen($name) > 0 ) {
            return $name;
        }

        return 'screenshot';
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
        if( $test instanceof \Srosato\BowlingBundle\Tests\Acceptance\AbstractAcceptanceTest ) {
            $session = $test->getSession();

            if( null !== $session ) {
                /* @var $driver \Behat\MinkBundle\Driver\SymfonyDriver */
                $driver = $session->getDriver();

                //TODO: screenshot name should reflect file, test method name and line number
                $name = $this->getScreenshotNameFromTrace($e->getTrace());
                $imageData = base64_decode($driver->wdSession->screenshot());
                $ssDir = $test->getContainer()->getParameter('kernel.root_dir') . '/../bin/selenium-screenshots';
                file_put_contents("{$ssDir}/{$name}.png", $imageData);
            }
        }
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
        // TODO: Implement startTest() method.
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