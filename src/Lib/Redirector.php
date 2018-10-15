<?php
namespace Redirector\Lib;

use Redirector\Lib\Urls\RedirectUrl;
use Redirector\Lib\Urls\FailedUrl;
use Redirector\Lib\Urls\UrlInterface;

class Redirector
{
    /**
     * Array of redirects
     *
     * @var array
     */
    private $redirects = [];

    /**
     * Construct the Redirector
     *
     * @param array $redirects
     * @return void
     */
    public function __construct(array $redirects = [])
    {
        $this->redirects = $redirects;
    }

    /**
     * Find the correct matching redirect for the given url or null if no redirect is found
     *
     * @param string $url The path part of the url
     * @return \Redirector\Lib\Urls\UrlInterface|null
     */
    public function find(string $url): ?UrlInterface
    {
        if (isset($this->redirects[$url])) {
            $redirect = $this->redirects[$url];

            if ((int)\substr($redirect['code'], 0, 1) === 3) {
                return new RedirectUrl($redirect['target'], $redirect['code']);
            } else {
                return new FailedUrl(null, $redirect['code']);
            }
        }

        foreach ($this->redirects as $redirectUrl => $target) {
            // Only interested if it has :slug or *
            if (\stripos($redirectUrl, ':slug') === false && \stripos($redirectUrl, '*') === false) {
                continue;
            }

            // Match with slug
            if (\stripos($redirectUrl, ':slug') !== false) {
                $escaped = \str_replace('/', '\/', $redirectUrl);
                $pattern = \str_replace(':slug', '([\w-]+)', $escaped);

                if (preg_match('/' . $pattern . '/i', $url, $slugMatches, PREG_UNMATCHED_AS_NULL)) {
                    $numberOfMatches = count($slugMatches) - 1;
                    $targetUrl = $target['target'];
                    for ($i = 1; $i <= $numberOfMatches; $i++) {
                        $targetUrl = \preg_replace('/:slug/i', $slugMatches[$i], $targetUrl, 1);
                    }

                    if (isset($targetUrl) && (int)\substr($target['code'], 0, 1) === 3) {
                        return new RedirectUrl($targetUrl, $target['code']);
                    }
                }
            }

            // Match with star
            if (\stripos($redirectUrl, '*') !== false) {
                $urlToMatch = preg_replace('/\/?\*/', '', $redirectUrl);
                if (\stripos($url, $urlToMatch) === false) {
                    continue;
                }

                return new RedirectUrl($target['target'], $target['code']);
            }
        }

        return null;
    }
}
