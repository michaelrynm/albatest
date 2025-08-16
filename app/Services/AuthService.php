<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
   public function register (array $data): array
   {
    $user = User::create([
        'name' => $data['name'] ?? null,
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
    ]);

    $token = $user->createToken('api')->plainTextToken;
    return compact('user', 'token');
   }

   public function login (string $email, string $password): ?array
   {
    /** @var \App\Models\User|null $user */
    $user = User::where('email', $email)->first();

    if (! $user || ! Hash::check($password, $user->password)){
        return null;
    }

    $token = $user->createToken('api')->plainTextToken;
    return compact(
        'user',
        'token'
    );
   }

   public function logout ($user): void
   {
     $user->currentAccessToken()?->delete();
   }

}

