<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class InertiaFlashTest extends TestCase
{
    public function test_success_flash_message_is_shared_with_inertia_pages(): void
    {
        $this->withSession([
            'success' => 'Jasa servis berhasil diperbarui.',
        ])
            ->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->where('flash.success', 'Jasa servis berhasil diperbarui.'));
    }
}
