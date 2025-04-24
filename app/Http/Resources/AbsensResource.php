<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsensResource extends JsonResource
{
    public $status;
    public $message;

    public function __construct($resource, $status = 'Success', $message = 'List of students')
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            // Jika resource kosong (null atau array kosong), kembalikan null di bagian data
            'data' => $this->resource ? parent::toArray($request) : null,
        ];
    }
}
