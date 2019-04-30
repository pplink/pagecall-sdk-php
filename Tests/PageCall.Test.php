<?php

declare(strict_types=1);

use PageCall\PageCall;
use PageCall\Exceptions\PageCallAuthenticationException;
use PageCall\Exceptions\PageCallAuthenticationTokenExpiredException;
use PageCall\Exceptions\PageCallSDKException;

final class PageCallTest extends PHPUnit\Framework\TestCase {
    public function testMissingRequirementParam()
    {
        $this->expectException(PageCallSDKException::class);
        $pagecall = new PageCall();
    }
}