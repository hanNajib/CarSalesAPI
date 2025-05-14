<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validations extends Model
{
    protected $table = "validations";
    protected $guarded = [];
    public $timestamps = false;

    public function validator() {
        return $this->belongsTo(Validators::class, "validator_id");
    }
}
