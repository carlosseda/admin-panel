<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DB\Fingerprint;

class FingerprintController extends Controller
{
    
    public function store(Request $request){
        
        $cookie_fingerprint = $request->cookie('fp');

        if($cookie_fingerprint == null){

            $fingerprint = Fingerprint::create([
                'fingerprint_code' => request('fingerprint_code'),
                'browser' => request('browser'),
                'browser_version' => request('browser_version'),
                'OS' => request('OS'),
                'resolution' => request('resolution')
            ]);
        }else{
            $fingerprint = Fingerprint::where('fingerprint_code', $cookie_fingerprint)->first();
        }

        $cookie_fingerprint = cookie()->forever('fp', $fingerprint->fingerprint_code);

        return response()->json([
            'cookie' => $cookie_fingerprint,
        ])->withCookie($cookie_fingerprint);
    }
}
