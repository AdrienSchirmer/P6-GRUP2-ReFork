<?php

$dom = new \DOMDocument();

test('assignment dom contains expected elements', function () {

    $html = '
        <h1>Demana el teu encàrrec</h1>
        <input id="name" />
        <textarea id="description"></textarea>
        <button type="submit">Enviar encàrrec</button>
    ';

    $dom = new DOMDocument();

    @$dom->loadHTML(
        '<?xml encoding="UTF-8">' . $html
    );

    expect(
        $dom->getElementsByTagName('h1')->item(0)->textContent
    )->toContain('Demana el teu encàrrec');

    expect(
        $dom->getElementById('description')
    )->not->toBeNull();

    expect(
        $dom->getElementById('name')
    )->not->toBeNull();
});