<?php
namespace Redirecter\Lib\Urls;

interface UrlInterface
{
    /**
     * Return the HTTP code for this url
     * 
     * @return int
     */
    public function getCode(): int;
}