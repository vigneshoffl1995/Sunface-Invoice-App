<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'proposal_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'proposal_date',
        'valid_until',
        'notes',
        'sub_total',
        'cgst',
        'sgst',
        'total',
        'status',
        'round_total',
        'round_value'
    ];

    protected $casts = [
    'proposal_date' => 'datetime',
    'valid_until' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(ProposalItem::class);
    }
}
