<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Validations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ValidationController extends Controller
{
    public function request(Request $req) {
        $req->validate([
            "job" => "required",
            "job_description" => "nullable",
            "income" => "nullable",
            "reason_accepted" => "nullable"
        ]);

        $validation = Validations::create([
            "society_id" => Auth::user()->id,
            "job" => $req->job,
            "job_description" => $req->job_description,
            "income" => $req->income,
            "reason_accepted" => $req->reason_accepted
        ]);

        return Controller::message("Request data validation sent successful");
    }

    public function get(Request $req) {
        $validation = Validations::where('society_id', Auth::user()->id)->with('validator')->get();

        return Controller::json([
            "validation" => $validation
        ]);
    }
}
