<?php

namespace Srosato\BowlingBundle\Tests\Developer;

use Srosato\BowlingBundle\Model\Game;

class BundleUsageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function creationOfExtensionShouldHaveTheProperAlias()
    {
        $ext = new \Srosato\BowlingBundle\DependencyInjection\SrosatoBowlingExtension();
        $ext->load(array(), new \Symfony\Component\DependencyInjection\ContainerBuilder());

        $this->assertEquals('srosato_bowling', $ext->getAlias());
    }

    /**
     * @test
     */
    public function bundleShouldBeCreatable()
    {
        new \Srosato\BowlingBundle\SrosatoBowlingBundle();
    }
}
