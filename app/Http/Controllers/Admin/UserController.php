<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\DB\User;
use App\Http\Requests\Admin\UserRequest;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        
        $this->user = $user;
    }
    
    public function index()
    {

        $view = View::make('admin.users.index')
                ->with('user', $this->user)
                ->with('users', $this->user->where('active', 1)->get());

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

        $view = View::make('admin.users.index')
        ->with('user', $this->user)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(UserRequest $request)
    {            
        
        if (request('password') !== null) {

            $user = User::updateOrCreate([
                'id' => request('id')],[
                'name' => request('name'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                'active' => 1,
            ]);
            
        }else{

            $user = User::updateOrCreate([
                'id' => request('id')],[
                'name' => request('name'),
                'email' => request('email'),
                'active' => 1,
            ]);
        }

        $view = View::make('admin.users.index')
        ->with('users', $this->user->where('active', 1)->get())
        ->with('user', $user)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $user->id,
        ]);
    }

    public function edit(user $user)
    {
        $view = View::make('admin.users.index')
        ->with('user', $user)
        ->with('users', $this->user->where('active', 1)->get());   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function show(user $user){

    }

    public function destroy(user $user)
    {
        $user->active = 0;
        $user->save();

        $view = View::make('admin.users.index')
            ->with('user', $this->user)
            ->with('users', $this->user->where('active', 1)->get())
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }
}

