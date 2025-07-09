<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\InvoiceItem;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number', 'customer_id', 'invoice_date', 'valid_until',
        'sub_total', 'cgst', 'sgst', 'total', 'notes', 'status'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'valid_until' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
