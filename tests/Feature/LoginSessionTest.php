<?php

namespace Tests\Feature;

use Illuminate\Support\Env;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LoginSessionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Exercise real CSRF validation, which Laravel normally skips in tests.
        $this->app->instance('env', 'production');
    }

    #[DataProvider('sessionDomains')]
    public function test_login_cookies_work_on_the_public_host(?string $domain, ?string $expectedDomain): void
    {
        $environment = Env::getRepository();
        $originalDomain = $environment->get('SESSION_DOMAIN');

        try {
            $environment->set('SESSION_DOMAIN', $domain ?? 'null');
            config(['session' => require config_path('session.php')]);
        } finally {
            if ($originalDomain === null) {
                $environment->clear('SESSION_DOMAIN');
            } else {
                $environment->set('SESSION_DOMAIN', $originalDomain);
            }
        }

        $response = $this->get('https://aurixbranding.co.ke/login');
        $response->assertOk();

        $cookies = [];
        foreach ($response->headers->getCookies() as $cookie) {
            $this->assertSame($expectedDomain, $cookie->getDomain());
            $cookies[$cookie->getName()] = $cookie->getValue();
        }

        $this->assertArrayHasKey(config('session.cookie'), $cookies);
        $this->assertArrayHasKey('XSRF-TOKEN', $cookies);
        preg_match('/name="_token" value="([^"]+)"/', $response->getContent(), $matches);
        $this->assertArrayHasKey(1, $matches);

        // An empty form must reach credential validation instead of failing CSRF.
        $this->withUnencryptedCookies($cookies)
            ->post('https://aurixbranding.co.ke/login', ['_token' => $matches[1]], ['Accept' => 'application/json'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password']);
    }

    public static function sessionDomains(): array
    {
        return [
            'copied IPv4 localhost setting' => ['127.0.0.1', null],
            'copied localhost setting' => ['localhost', null],
            'copied IPv6 localhost setting' => ['::1', null],
            'host-only default' => [null, null],
            'explicit shared domain' => ['.aurixbranding.co.ke', '.aurixbranding.co.ke'],
        ];
    }

    public function test_login_still_rejects_an_invalid_csrf_token(): void
    {
        $this->withSession(['_token' => 'current-token'])
            ->post('/login', ['_token' => 'stale-token'], ['Accept' => 'application/json'])
            ->assertStatus(419);
    }
}
