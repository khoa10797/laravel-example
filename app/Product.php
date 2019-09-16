<?php

namespace App;

use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use FullTextSearch;

    protected $searchable = [
        'name'
    ];

    protected $fillable = [
        'category_id',
        'name',
        'image',
        'price',
        'note'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function invoiceDetails()
    {
        return $this->belongsToMany(InvoiceDetail::class);
    }
}
