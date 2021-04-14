<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CostumerRequest;
use App\Models\DB\Costumer; 

class CostumerController extends Controller
{
    protected $costumer;

    function __construct(Costumer $costumer)
    {
        $this->middleware('auth');

        $this->costumer = $costumer;
    }

    public function index()
    {
        
        $view = View::make('admin.costumers.index')
                ->with('costumer', $this->costumer)
                ->with('costumers', $this->costumer->where('active', 1)->get());

        if(request()->ajax()) {
            
            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }

        return $view;
    }

    public function create()
    {

        $view = View::make('admin.costumers.index')
        ->with('costumer', $this->costumer)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(CostumerRequest $request)
    {            
        
        $costumer = $this->costumer->updateOrCreate([
            'id' => request('id')],[
            'name' => request('name'),
            'surname' => request('surname'),
            'telephone' => request('telephone'),
            'email' => request('email'),
            'country_id' => request('country_id'),
            'city' => request('city'),
            'address' => request('address'),
            'postcode' => request('postcode'),
            'active' => 1,
        ]);

        $view = View::make('admin.costumers.index')
        ->with('costumers', $this->costumer->where('active', 1)->get())
        ->with('costumer', $costumer)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $costumer->id,
        ]);
    }

    public function edit(Costumer $costumer)
    {
        $view = View::make('admin.costumers.index')
        ->with('costumer', $costumer)
        ->with('costumers', $this->costumer->where('active', 1)->get());   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function show(Costumer $costumer){

    }

    public function destroy(Costumer $costumer)
    {
        $costumer->active = 0;
        $costumer->save();

        $view = View::make('admin.costumers.index')
            ->with('costumer', $this->costumer)
            ->with('costumers', $this->costumer->where('active', 1)->get())
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }
}
