<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'activity',
        'hsn_code',
        'quantity',
        'rate',
        'amount'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function hsn()
    {
        return $this->belongsTo(Hsn::class, 'hsn_code');
    }

    // public function service()
    // {
    //     return $this->belongsTo(Service::class);
    // }
}
