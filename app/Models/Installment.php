<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = "installment";
    protected $guarded = [];

    public function brand() {
        return $this->belongsTo(Brand::class, "brand_id");
    }

    public function availableMonth() {
        return $this->hasMany(AvailableMonth::class, 'installment_id');
    }

    public function installmentApplySocieties() {
        return $this->hasMany(InstallmentApplySociety::class, "installment_id");
    }
    
}
