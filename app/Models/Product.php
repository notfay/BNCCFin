<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'quantity',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function formatPrice()
    {
        return 'Rp. ' . number_format($this->price, 0, ',', '.');
    }

    public function isOutOfStock()
    {
        return $this->quantity <= 0;
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}