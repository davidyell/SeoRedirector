<?php
namespace Tests\Lib;

use PHPUnit\Framework\TestCase;
use Redirector\Lib\Redirector;
use Redirector\Lib\Urls\RedirectUrl;
use Redirector\Lib\Urls\FailedUrl;

class RedirectorTest extends TestCase
{
    /**
     * Instance of the Redirector
     *
     * @var \Redirector\Lib\Redirector
     */
    private $Redirector;

    public function setUp()
    {
        $redirects = [
            '/compare/tv-deals' => [
                'target' => '/compare',
                'code' => 302
            ],
            '/products/sky/:slug' => [
                'target' => '/providers/sky/products/:slug',
                'code' => 301
            ],
            '/news-and-features/:slug' => [
                'target' => '/guides/:slug',
                'code' => 301
            ],
            '/providers/:slug/products' => [
                'target' => '/providers/products/:slug',
                'code' => 302
            ],
            '/type/student-broadband' => [
                'target' => '/broadband-types',
                'code' => 301
            ],
            '/catalogs/view/top-5-broadband-packages' => [
                'target' => null,
                'code' => 410
            ],
            '/catalogs/view/top-5-fastest-broadband' => [
                'code' => 410
            ],
            '/blog/*' => [
                'target' => '/guides',
                'code' => 301
            ]
        ];

        $this->Redirector = new Redirector($redirects);
    }

    public function findDataProvider()
    {
        return [
            ['/compare/tv-deals', '/compare', 302],
            ['/products/sky/sky-q-multiscreen', '/providers/sky/products/sky-q-multiscreen', 301],
            ['/news-and-features/what-broadband-do-i-need-for-streaming', '/guides/what-broadband-do-i-need-for-streaming', 301],
            ['/type/student-broadband', '/broadband-types', 301],
            ['/blog', '/guides', 301],
            ['/blog/2019/05/12/example-post', '/guides', 301],
            ['/providers/sky/products', '/providers/products/sky', 302]
        ];
    }

    /**
     * Test the redirect finder method
     *
     * @dataProvider findDataProvider
     *
     * @return void
     */
    public function testFind(string $url, ?string $expectedUrl, int $code)
    {
        $result = $this->Redirector->find($url);
        $expected = new RedirectUrl($expectedUrl, $code);

        $this->assertEquals($expected, $result);
    }

    public function testFindWithFailure()
    {
        $url = '/catalogs/view/top-5-broadband-packages';
        $code = 410;

        $result = $this->Redirector->find($url);
        $expected = new FailedUrl(null, $code);

        $this->assertEquals($expected, $result);
    }

    public function testFindWithFailureWithNoTarget()
    {
        $url = '/catalogs/view/top-5-fastest-broadband';
        $code = 410;

        $result = $this->Redirector->find($url);
        $expected = new FailedUrl(null, $code);

        $this->assertEquals($expected, $result);
    }
}
