<?php


use App\Models\User;

it('can create a Payout', function () {
    $this->assertDatabaseCount('payouts', 0);

    $inputData = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'bank_name' => 'ACME',
        'bank_country' => 'MA',
        'iban' => 'MA 14 20041 01005 0500013M026 06',
        'bic' => 'AGRI-FR PP-848',
    ];

    $user = User::factory()->create();
    $this->actingAs($user);

    $this->postJson(
        uri: '/api/payouts',
        data: $inputData
    )
        ->assertStatus(201)
        ->assertSessionHasNoErrors()
        ->assertJson([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'bank_name' => 'ACME',
            'bank_country' => 'MA',
            'original_payout_info' => [
                'iban' => 'MA 14 20041 01005 0500013M026 06',
                'bic' => 'AGRI-FR PP-848',
            ],
            'payout_info' => [
                'iban' => 'MA1420041010050500013M02606',
                'bic' => 'AGRIFRPP848',
            ]
        ])
    ;

    $this->assertDatabaseCount('payouts', 1);
    $this->assertDatabaseHas('payouts', [
        ...$inputData,
        'user_id' => $user->id,
    ]);
});

it('validates user input', function () {
    $inputData = [
        'iban' => 'MA 14',
        'bic' => 'AGRI-FR',
    ];

    $user = User::factory()->create();
    $this->actingAs($user);

    $this->postJson(
        uri: '/api/payouts',
        data: $inputData
    )
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'first_name' => 'The first name field is required.',
            'last_name' => 'The last name field is required.',
            'bank_name' => 'The bank name field is required.',
            'bank_country' => 'The bank country field is required.',
            'iban' => 'The iban field format is invalid.',
            'bic' => 'The bic field format is invalid.'
        ])
    ;
});
