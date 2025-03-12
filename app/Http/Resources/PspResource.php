<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class PspResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'bank_name' => $this->bank_name,
            'bank_country' => $this->bank_country,
            'original_payout_info' => [
                'iban' => $this->iban,
                'bic' => $this->bic,
            ],
            'payout_info' => [
                'iban' => $this->sanitize($this->iban),
                'bic' => $this->sanitize($this->bic),
            ],
        ];
    }

    private function sanitize(string $value): string
    {
        return Str::of($value)->remove(search: ['-', ' '])->toString();
    }
}
