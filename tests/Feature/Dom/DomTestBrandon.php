<?php

use Inertia\Testing\AssertableInertia as Assert;

test('assignment form renders correctly', function () {
    $response = $this->get('/assignments/create');

    $response->assertStatus(200);

    $response->assertSee('Demana el teu encàrrec');

    $response->assertInertia(
        fn(Assert $page) =>
        $page->component('Assignments/Create')
    );
});

test('form submission works', function () {

    $response = $this->post('/assignments', [
        'name' => 'Test',
        'address' => 'test@mail.com',
        'phone_number' => '123123123',
        'description' => 'Descripció',
    ]);

    $response->assertStatus(302); 
});