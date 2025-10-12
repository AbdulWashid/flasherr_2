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
                        'email',
                        'country',
                        'city',
                        'address',
                        'network_type',
                        'document_path',
                        'photo_path',
                        'address_proof_path',
                    ];

    /**
     * Get the sale associated with the buy request.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
