<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Society extends Model
{
    use HasApiTokens;

    protected $guarded = [];
    protected $table = "societies";
    protected $hidden = ["password"];

    public function regional() {
        return $this->belongsTo(Regionals::class, 'regional_id');
    }

    public function validations() {
        return $this->hasMany(Validations::class, 'society_id');
    }

}
