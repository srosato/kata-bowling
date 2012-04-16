<?php

namespace Srosato\BowlingBundle\Tests;

use Srosato\BowlingBundle\Model\Bowling;

class BundleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        $ext = new \Srosato\BowlingBundle\DependencyInjection\SrosatoBowlingExtension();
        $ext->load(array(), new \Symfony\Component\DependencyInjection\ContainerBuilder());

        $this->assertEquals('srosato_bowling', $ext->getAlias());

        new \Srosato\BowlingBundle\SrosatoBowlingBundle();
    }
}
