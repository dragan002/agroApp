<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['farmer_id', 'reviewer_name', 'body', 'rating', 'ip_hash'];

    public function farmer()
    {
        return $this->belongsTo(FarmerProfile::class, 'farmer_id');
    }
}
