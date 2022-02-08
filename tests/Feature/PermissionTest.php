<?php

namespace Dealskoo\Affiliate\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions()
    {
        self::assertNotNull(PermissionManager::getPermission('affiliates.index'));
        self::assertNotNull(PermissionManager::getPermission('affiliates.show'));
        self::assertNotNull(PermissionManager::getPermission('affiliates.edit'));
    }
}
