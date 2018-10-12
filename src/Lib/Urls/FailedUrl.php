<?php
namespace Redirecter\Lib\Urls;

class FailedUrl implements UrlInterface
{
    /**
     * The text to send with the response
     * 
     * @var string
     */
    private $responseText = '(╯°□°）╯︵ ┻━┻';

    /**
     * HTTP code to use for the redirect
     *
     * @var int Valid HTTP code
     */
    private $code = 404;

    /**
     * Contruct the class
     *
     * @param string $url String url path eg, /example/index
     * @param int|null $code HTTP code to use
     * @return void
     */
    public function __construct(?string $responseText, ?int $code)
    {
        if ($responseText) {
            $this->responseText = $responseText;
        }

        if ($code) {
            $this->code = $code;
        }
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

    /**
     * Get the response text
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->responseText;
    }
}