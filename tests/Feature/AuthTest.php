<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class AuthTest extends TestCase
{
    
    public function test_login()
    {
        $response = $this->withHeaders([
            'Accept' => 'Aplication/json'
        ])->post('/api/v1/auth/login', ['data' => 'kailee00@example.org']);
        $response->assertStatus($response->status());
       
    }
    public function test_register()
    {
        $response = $this->withHeaders([
            'Accept' => 'Aplication/json'
        ])->post('/api/v1/auth/register', [
            'name' => 'Ahmed',
            'email' => 'Ahmed@gmail.com',
            'mobile' => '01032432483',
            'image' =>null,
            'balance'=>200.39 ,
            'currency' => 'EGP',
            'password' => Hash::make('Ahmed@gmail.com'), // password
            'remember_token' => Str::random(10),
        ]);
        $response->assertStatus($response->status());
       
    }
    
}
