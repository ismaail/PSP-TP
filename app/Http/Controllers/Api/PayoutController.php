<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayoutRequest;
use App\Http\Resources\PspResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

class PayoutController extends Controller
{
    public function __invoke(PayoutRequest $request, #[CurrentUser] User $user)
    {
        $payout = $user->payouts()
            ->create($request->validated());

        return new PspResource($payout)
            ->response()->setStatusCode(201);
    }
}
