<?php
namespace Redirector\Lib\Urls;

class RedirectUrl implements UrlInterface
{
    /**
     * Url to redirect to
     *
     * @var string
     */
    private $url;

    /**
     * HTTP code to use for the redirect
     *
     * @var int Valid HTTP code
     */
    private $code = 301;

    /**
     * Contruct the class
     *
     * @param string $url String url path eg, /example/index
     * @param int|null $code HTTP code to use
     * @return void
     */
    public function __construct(string $url, ?int $code)
    {
        $this->url = $url;

        if ($code) {
            $this->code = $code;
        }
    }

    /**
     * Get the redirect url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get the http code
     *
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }
}
