<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstallmentCarResource;
use App\Models\Installment;
use Illuminate\Http\Request;

class InstalmentController extends Controller
{
    public function getInstalmentCars(Request $req) {
        $instalment = Installment::with(['brand', 'availableMonth'])->get();

        return Controller::json([
            "cars" => InstallmentCarResource::collection($instalment)
        ]);
    }

    public function getInstalmentById(Request $req, $id) {
        $instalment = Installment::where("id", $id)->with(['brand', 'availableMonth'])->first();
        if(!$instalment) {
            return Controller::message('Instalment Not Found', 404);
        }

        return Controller::json([
            "instalment" => new InstallmentCarResource($instalment)
        ]);
    }
}
