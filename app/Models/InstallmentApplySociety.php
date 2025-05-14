<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentApplySociety extends Model
{
    protected $table = "installment_apply_societies";
    protected $guarded = [];
    public $timestamps = false;


    public function availableMonth() {
        return $this->belongsTo(AvailableMonth::class, "available_month_id");
    }

    public function installment() {
        return $this->belongsTo(Installment::class, "installment_id");
    }

    public function society() {
        return $this->belongsTo(Society::class, 'society_id');
    }

    public function installmentApplyStatus() {
        return $this->hasOne(InstallmentApplyStatus::class, 'installment_apply_societies_id');
    }
}
