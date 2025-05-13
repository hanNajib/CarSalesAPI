<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Society extends Model
{
    use HasApiTokens;

    protected $guarded = [];
    protected $table = "societies";

    public function regional() {
        return $this->belongsTo(Regionals::class, 'regional_id');
    }
}
