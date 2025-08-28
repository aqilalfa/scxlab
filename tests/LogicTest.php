<?php

use PHPUnit\Framework\TestCase;
use App\Profile; // Mengimpor class Profile yang sudah kita pisahkan

class LogicTest extends TestCase
{
    public function testAdminRoleIsCorrectlyAssigned()
    {
        // Skenario 1: Membuat objek Profile dengan peran admin
        $profile = new Profile('admin_user', true);
        
        // Memeriksa (assert) bahwa properti isAdmin harus true
        $this->assertTrue($profile->isAdmin);
        
        // Memeriksa output string
        $this->assertEquals("User: admin_user, Role: Admin", (string)$profile);
    }

    public function testRegularUserRoleIsCorrectlyAssigned()
    {
        // Skenario 2: Membuat objek Profile dengan peran user biasa
        $profile = new Profile('regular_user', false);
        
        // Memeriksa (assert) bahwa properti isAdmin harus false
        $this->assertFalse($profile->isAdmin);

        // Memeriksa output string
        $this->assertEquals("User: regular_user, Role: User", (string)$profile);
    }
}