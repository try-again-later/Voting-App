<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class UserAvatarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_has_avatar_when_not_registered_in_gravatar()
    {
        $user = User::factory()->create([
            'name' => 'Some name',
            'email' => 'does.not.exist@example.com',
        ]);

        $avatarResponse = Http::get($user->avatar());
        $this->assertTrue($avatarResponse->successful());
    }
}
