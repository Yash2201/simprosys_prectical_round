<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class DecryptResponseController extends Controller
{

    public function decrypt_response(Request $request){
        try {
            $decrypted = Crypt::decryptString($request->enc_code);
            
            return response()->json(json_decode($decrypted));
        } catch (DecryptException $th) {
            return response()->json(['status'=>500,'error'=>$th]);
        }
    }
}
