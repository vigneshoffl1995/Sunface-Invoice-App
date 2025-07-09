<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalItem extends Model
{
    protected $fillable = [
        'proposal_id',
        'activity',
        'quantity',
        'rate',
        'amount',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
