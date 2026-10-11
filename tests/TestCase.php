<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Halaman memakai @vite; di test cukup dilewati supaya tidak perlu build aset.
        $this->withoutVite();
    }
}
