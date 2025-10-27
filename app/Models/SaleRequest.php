<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleRequest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone_number', 'email', 'whatsapp_number', 'wallet_address', 'quantity', 'ip_address', 'documents_paths', 'status', 'is_read','rate'];

     /**
     * The attributes that should be cast.
     *
     * @var array
     */

    protected $casts = [
        'documents_paths' => 'array',
    ];

    /**
     * Get the sale associated with the SaleRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class);
    }
}
