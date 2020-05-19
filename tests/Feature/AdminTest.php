<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_see_the_admin_panel()
    {
        $user = $this->signInAsAdmin();

        $this->get('/admin')->assertOk()->assertSee($user->nome);
    }

    /** @test */
    public function a_logged_in_user_can_see_his_info_on_the_admin_panel()
    {
        $user = $this->signInAsAdmin();

        $this->get('/admin/perfil')
            ->assertOk()
            ->assertSee($user->nome)
            ->assertSee($user->username)
            ->assertSee($user->email);
    }
}