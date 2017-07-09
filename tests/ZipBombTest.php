<?php

namespace AdrianMejias\ZipBomb\Test;

class ZipBombTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function is_this_person_serious()
    {
        $this->call('get', 'wordpress');
        $this->assertTrue(true);
    }
}
