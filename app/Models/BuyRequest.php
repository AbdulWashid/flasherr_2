<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuyRequest extends Model
{
    use HasFactory;
    protected $fillable = [
                        'sale_id',
                        'name',
                        'phone_number',
                        'wallet_address',
                        'quantity',
                        'status',
                        'transaction_id',
                        'payment_proof',
                        'email',
                        'network_type',
                    ];

    /**
     * Get the sale associated with the buy request.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
