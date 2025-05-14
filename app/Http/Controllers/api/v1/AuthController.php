<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $req) {
        $req->validate([
            "id_card_number" => "required",
            "password" => "required"
        ]);

        $society = Society::where('id_card_number', $req->id_card_number)->first();
        
        if(!$society || $society->password != $req->password) {
            return Controller::message("ID Card Number or Password incorrect", 401);
        }

        $token = $society->createToken('society')->plainTextToken;

        return Controller::json([
            "name" => $society->name,
            "born_date" => $society->born_date,
            "gender" => $society->gender,
            "address" => $society->address,
            "token" => $token,
            "regional" => $society->load('regional')->regional
        ]);
    }

    public function logout(Request $req) {
        $user = Auth::user();
        $user->tokens()->delete();

        return Controller::message('Logout Success');
    }
}
