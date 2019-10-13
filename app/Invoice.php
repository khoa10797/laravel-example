<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'email',
        'address',
        'price'
    ];

    public function invoiceDetails()
    {
        $this->belongsToMany(InvoiceDetail::class);
    }
}
