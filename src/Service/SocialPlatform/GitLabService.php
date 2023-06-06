<?php

namespace Devtvn\Social\Service\SocialPlatform;

use Devtvn\Social\Facades\Social;
use Devtvn\Social\Helpers\CoreHelper;
use Devtvn\Social\Helpers\EnumChannel;
use Devtvn\Social\Repositories\UserRepository;
use Devtvn\Social\Service\ACoreService;
use Devtvn\Social\Service\ICoreService;
use Devtvn\Social\Traits\Response;
use Illuminate\Support\Facades\Hash;

class GitLabService extends ACoreService
{
    use Response;

    public function __construct()
    {
        $this->platform = Social::driver(EnumChannel::GITLAB);
        parent::__construct();
    }

    public function getStructure(...$payload)
    {
        [$token, $user] = $payload;
        return [
            'internal_id' => (string)$user['data']['id'],
            'first_name' => @$user['data']['name'] ?? @$user['data']['username'],
            'last_name' => '',
            'email' => @$user['data']['email'],
            'address' => @$user['data']['location'],
            'email_verified_at' => now(),
            'platform' => EnumChannel::GITLAB,
            'avatar' => @$user['data']['avatar_url'],
            'password' => Hash::make(123456789),
            'status' => true,
            'access_token' => @$token['data']['access_token'],
            'refresh_token' => @$token['data']['refresh_token'],
            'expire_token' => date("Y-m-d H:i:s", time() + @$token['data']['expires_in'] ?? 0),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function handleAdditional(array $payload, ...$variable)
    {
        // TODO: Implement handleAdditional() method.
    }
}