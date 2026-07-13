<?php

namespace Tests\Feature;

use Tests\TestCase;

class WordPressProbeRouteTest extends TestCase
{
    public function test_php_probe_under_blog_returns_not_found_for_get(): void
    {
        $this->get('/blog/wp-login.php')->assertNotFound();
    }

    public function test_php_probe_under_blog_returns_not_found_for_post(): void
    {
        $this->post('/blog/wp-login.php')->assertNotFound();
    }
}
