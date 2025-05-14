<?php

namespace App\Http\Controllers\api\v1;

use Throwable;
use App\Models\Validations;
use Illuminate\Http\Request;
use App\Models\AvailableMonth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\InstalmentApplicationResource;
use App\Models\Installment;
use Illuminate\Support\Facades\Auth;
use App\Models\InstallmentApplySociety;

class ApplicationController extends Controller
{
    public function applying(Request $req)
    {
        $req->validate([
            "instalment_id" => "required|exists:installment,id",
            "months" => "required"
        ]);


        $validation = Validations::where('society_id', Auth::user()->id)->first();
        if (!$validation || $validation->status !== "accepted") {
            return Controller::message("Your data validator must be accepted by validator before", 401);
        }

        $installment = Installment::where("id", $req->instalment_id)->first();

        $installmentSociety = InstallmentApplySociety::where("society_id", Auth::user()->id)->first();
        if ($installmentSociety) {
            return Controller::message("Application for a instalment can only be once", 401);
        }

        try {
            DB::beginTransaction();
            $availableMonth = AvailableMonth::firstOrCreate([
                "installment_id" => $req->instalment_id,
                "month" => $req->month,
                "description" => $installment->description,
                "nominal" => $installment->price * $req->months
            ]);


            $applyInstalment = InstallmentApplySociety::create([
                "installment_id" => $req->instalment_id,
                "available_month_id" => $availableMonth->id,
                "date" => now(),
                "notes" => $req->notes,
                "society_id" => Auth::user()->id
            ]);

            $applyInstalmentstatus = $applyInstalment->installmentApplyStatus()->firstOrCreate([
                "date" => now(),
                "society_id" => Auth::user()->id,
                "installment_id" => $req->instalment_id,
                "available_month_id" => $availableMonth->id,
                "status" => "pending"
            ]);

            DB::commit();
            return Controller::message("Applying for Instalment successful");
        } catch (Throwable $e) {
            DB::rollBack();
            return Controller::message("Applying for Instalment Failed", 400);
        }
    }

    public function getAll(Request $req)
    {
        $society = Auth::user();
        $installment = Installment::with(['brand'])
            ->with(['installmentApplySocieties' => function($query) use ($society) {
            $query->where('society_id', $society->id)
                ->with(['installmentApplyStatus', 'availableMonth']);
            }])
            ->get();

        return Controller::json([
            "instalments" => InstalmentApplicationResource::collection($installment)
        ]);
    }
}
