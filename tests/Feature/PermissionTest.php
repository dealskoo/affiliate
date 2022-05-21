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
        $this->assertNotNull(PermissionManager::getPermission('affiliates.index'));
        $this->assertNotNull(PermissionManager::getPermission('affiliates.show'));
        $this->assertNotNull(PermissionManager::getPermission('affiliates.edit'));
        $this->assertNotNull(PermissionManager::getPermission('affiliates.login'));
    }
}
