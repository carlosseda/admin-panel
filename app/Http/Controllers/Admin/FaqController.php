<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\DB\Faq; 
use Debugbar;

class FaqController extends Controller
{
    protected $faq;

    function __construct(Faq $faq, Agent $agent)
    {
        $this->middleware('auth');
        $this->agent = $agent;
        $this->faq = $faq;
    }

    public function index()
    {
        
        if($this->agent->isMobile()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)
            ->paginate(10));
        }

        if($this->agent->isDesktop()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)
            ->paginate(6));
        }
    
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

        $view = View::make('admin.faqs.index')
        ->with('faq', $this->faq)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(FaqRequest $request)
    {            
        
        $faq = $this->faq->updateOrCreate([
            'id' => request('id')],[
            'name' => request('name'),
            'active' => 1,
            'category_id' => request('category_id'),
        ]);

        if($this->agent->isMobile()){
            $view = View::make('admin.faqs.index')
            ->with('faqs', $this->faq->where('active', 1)->paginate(10))
            ->with('faq', $faq)
            ->renderSections();        
        }

        if($this->agent->isDesktop()){
            $view = View::make('admin.faqs.index')
            ->with('faqs', $this->faq->where('active', 1)->paginate(6))
            ->with('faq', $faq)
            ->renderSections();        
        }

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $faq->id,
        ]);
    }

    public function edit(Faq $faq)
    {
        if($this->agent->isMobile()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $faq)
            ->with('faqs', $this->faq->where('active', 1)->paginate(10));        
        }

        if($this->agent->isDesktop()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $faq)
            ->with('faqs', $this->faq->where('active', 1)->paginate(6));        
        }
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function show(Faq $faq){

     
    }

    public function destroy(Faq $faq)
    {
        $faq->active = 0;
        $faq->save();

        if($this->agent->isMobile()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)->paginate(10))
            ->renderSections();        
        }

        if($this->agent->isDesktop()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)->paginate(6))
            ->renderSections();        
        }
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }

    public function filter($filters = null){

        $query = $this->faq->query();

        Debugbar::info(request()->json()->all());

        $query->when($filters->category_id, function ($q, $category_id) {

            if($category_id == 'all'){
                return $q;
            }
            else{
                return $q->where('category_id', $category_id);
            }
        });

        $query->when($filters->search, function ($q, $search) {

            if($search == null){
                return $q;
            }
            else {
                return $q->where('t_faqs.name', 'like', "%$search%");
            }   
        });

        $query->when($filters->created_at_from, function ($q, $created_at_from) {

            if($created_at_from == null){
                return $q;
            }
            else {
                $q->whereDate('t_faqs.created_at', '>=', $created_at_from);
            }   
        });

        $query->when($filters->created_at_since, function ($q, $created_at_since) {

            if($created_at_since == null){
                return $q;
            }
            else {
                $q->whereDate('t_faqs.created_at', '<=', $created_at_since);
            }   
        });

        $query->when($filters->order, function ($q, $order) use ($request) {

            $q->orderBy($order, $request->direction);
        });
        
        if($this->agent->isMobile()){
            $faqs = $query->join('t_faqs_categories', 't_faqs.category_id', '=', 't_faqs_categories.id')
            ->where('t_faqs.active', 1)->paginate(10);  
        }

        if($this->agent->isDesktop()){
            $faqs = $query->join('t_faqs_categories', 't_faqs.category_id', '=', 't_faqs_categories.id')
            ->where('t_faqs.active', 1)->paginate(6);   
        }

        $view = View::make('admin.faqs.index')
            ->with('faqs', $faqs)
            ->renderSections();

        return response()->json([
            'table' => $view['table'],
        ]);
    }

    public function filterPagination(){
        
    }
}
