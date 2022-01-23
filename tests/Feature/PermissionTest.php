<?php

namespace Dealskoo\Affiliate\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Affiliate\Tests\TestCase;

class PermissionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_permissions()
    {
        self::assertNotNull(PermissionManager::getPermission('affiliates.index'));
        self::assertNotNull(PermissionManager::getPermission('affiliates.show'));
        self::assertNotNull(PermissionManager::getPermission('affiliates.edit'));
    }
}
