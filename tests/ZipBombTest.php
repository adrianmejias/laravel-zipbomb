<?php

namespace AdrianMejias\ZipBomb\Test;

class ZipBombTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDummyRoutes();
    }

    /** @test */
    public function it_this_person_serious()
    {
        $this->call('get', 'wordpress');
        $this->assertResponseOk();
    }
}