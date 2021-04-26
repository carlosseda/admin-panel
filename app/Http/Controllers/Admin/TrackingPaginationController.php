<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DB\TrackingPagination; 
use Carbon\Carbon;

class TrackingPaginationController extends Controller
{
    protected $tracking;

    function __construct(TrackingPagination $tracking_pagination)
    {
        $this->middleware('auth');
        $this->tracking_pagination = $tracking_pagination;
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

        $last_tracking = $this->tracking_pagination->latest('created_at')->first();

        $tracking_pagination = $this->tracking_pagination->create([
            'origin' => request('origin'),
            'route' => request('route'),
            'move' => request('move'),
            'entity' => request('entity'),
            'page' => request('page'),
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
