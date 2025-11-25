<?php

use App\Models\User;

test('create user that will pass validation', function () {
    // Arrange
    $data = [
        'name' => 'John Smith',
        'email' => 'john@gmail.com',
        'password' => 'password123',
        'role' => 'admin',
    ];

    // Act
    $user = User::create($data);

    // Assert
    expect($user->name)->toBe($data['name']);
    expect($user->email)->toBe($data['email']);
    expect($user->role)->toBe($data['role']);
});


test('create user that will fail validation due to missing email', function () {
    // Arrange
    $data = [
        'name' => 'Jane Doe',
        // 'email' is missing
        'password' => 'password123',
        'role' => 'user',
    ];

    // Act 
    try {
        User::create($data);
        $failed = false;
    } catch (\Illuminate\Database\QueryException $e) {
        $failed = true;
    }

    // Assert
    expect($failed)->toBeTrue();
    expect(User::where('name', 'Jane Doe')->exists())->toBeFalse();
});
