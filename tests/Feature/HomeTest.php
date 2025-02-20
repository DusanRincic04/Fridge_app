<?php

test('Home page loading', function () {
    $response = $this->get('/');

    $response->assertStatus(200);

});
