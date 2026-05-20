<?php

use App\Models\Email;
use App\Http\Controllers\Admin\EmailsController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('returns JSON with all emails', function () {
    Email::create(['email' => 'test@gmail.com', 'active' => 1]);
    Email::create(['email' => 'test2@gmail.com', 'active' => 0]);

    $request = Request::create('/admin/emails', 'GET', [], [], [], [
        'HTTP_ACCEPT' => 'application/json',
    ]);

    $response = (new EmailsController)->index($request);

    expect($response->getData())->toHaveCount(2);
});

it('returns only active emails when filter=active', function () {
    Email::create(['email' => 'test3@gmail.com', 'active' => 1]);
    Email::create(['email' => 'test4@gmail.com', 'active' => 0]);

    $request = Request::create('/admin/emails', 'GET', ['filter' => 'active'], [], [], [
        'HTTP_ACCEPT' => 'application/json',
    ]);

    $response = (new EmailsController)->index($request);

    expect($response->getData())->toHaveCount(1)
        ->and($response->getData()[0]->email)->toBe('test3@gmail.com');
});