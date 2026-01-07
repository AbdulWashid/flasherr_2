<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    /**
     * Get the user that owns the Sale
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected $fillable = [
        'sale_request_id',
        'quantity',
        'rate',
        'status',
        'is_verified',
        'price',
        'display_status',
        'city',
        'state',
        'country',
    ];
    public function saleRequest(): BelongsTo
    {
        return $this->belongsTo(SaleRequest::class);
    }
}
