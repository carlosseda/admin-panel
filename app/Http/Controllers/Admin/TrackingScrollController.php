<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DB\TrackingScroll; 
use Carbon\Carbon;

class TrackingScrollController extends Controller
{
    protected $tracking_scroll;

    function __construct(TrackingScroll $tracking_scroll)
    {
        $this->middleware('auth');
        $this->tracking_scroll = $tracking_scroll;
    }

    public function index()
    {
        
    }

    public function create()
    {

    }

    public function store(Request $request)
    {            
        $cookie_fingerprint = $request->cookie('fp');
        $last_tracking = null;

        $last_tracking = $this->tracking_scroll->latest('created_at')->first();

        if($last_tracking != null){
            $date = $last_tracking->created_at;
            $now = Carbon::now();
            $last_tracking->retention = $date->diffInSeconds($now);
            $last_tracking->save();
        }

        $tracking_scroll = $this->tracking_scroll->create([
            'difference_in_y' => request('difference_in_y'),
            'current_y_position' => request('current_y_position'),
            'origin' => request('origin'),
            'route' => request('route'),
            'move' => request('move'),
            'entity' => request('entity'),
            'fingerprint_code' => $cookie_fingerprint,
        ]);
        
        return response()->json([
        ]);
    }

    public function edit(Faq $faq)
    {
        
    }

    public function show(Faq $faq){

     
    }

    public function destroy(Faq $faq)
    {
        
    }

}
