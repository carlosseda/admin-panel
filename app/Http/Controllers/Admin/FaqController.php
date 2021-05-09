<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Http\Requests\Admin\FaqRequest;
use App\Vendor\Locale\Locale;
use App\Vendor\Image\Image;
use App\Models\DB\Faq; 

class FaqController extends Controller
{
    protected $agent;
    protected $locale;
    protected $image;
    protected $paginate;
    protected $faq;

    function __construct(Faq $faq, Agent $agent, Locale $locale, Image $image)
    {
        $this->middleware('auth');
        $this->agent = $agent;
        $this->locale = $locale;
        $this->image = $image;
        $this->faq = $faq;
        $this->faq->visible = 1;

        if ($this->agent->isMobile()) {
            $this->paginate = 10;
        }

        if ($this->agent->isDesktop()) {
            $this->paginate = 6;
        }

        $this->locale->setParent('faqs');
        $this->image->setEntity('faqs');
    }

    public function index()
    {
        $view = View::make('admin.faqs.index')
        ->with('faq', $this->faq)
        ->with('faqs', $this->faq->where('active', 1)
        ->orderBy('created_at', 'desc')
        ->paginate($this->paginate));
    
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
            'visible' => request('visible') == "true" ? 1 : 0 ,
            'category_id' => request('category_id'),
        ]);

        if(request('locale')){
            $locale = $this->locale->store(request('locale'), $faq->id);
        }

        if(request('images')){
            $images = $this->image->storeRequest(request('images'), 'webp', $faq->id);
        }

        if (request('id')){
            $message = \Lang::get('admin/faqs.faq-update');
        }else{
            $message = \Lang::get('admin/faqs.faq-create');
        }

        $view = View::make('admin.faqs.index')
        ->with('faqs', $this->faq->where('active', 1)->orderBy('created_at', 'desc')->paginate($this->paginate))
        ->with('faq', $faq)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message,
            'id' => $faq->id,
        ]);
    }

    public function edit(Faq $faq)
    {
        $locale = $this->locale->show($faq->id);

        $view = View::make('admin.faqs.index')
        ->with('locale', $locale)
        ->with('faq', $faq)
        ->with('faqs', $this->faq->where('active', 1)->orderBy('created_at', 'desc')->paginate($this->paginate));        
        
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

        $view = View::make('admin.faqs.index')
        ->with('faq', $faq)
        ->with('faqs', $this->faq->where('active', 1)->orderBy('created_at', 'desc')->paginate($this->paginate))
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
        ]);
    }

    public function destroy(Faq $faq)
    {
        $faq->active = 0;
        $faq->save();

        $message = \Lang::get('admin/faqs.faq-delete');

        $view = View::make('admin.faqs.index')
        ->with('faq', $this->faq)
        ->with('faqs', $this->faq->where('active', 1)->orderBy('created_at', 'desc')->paginate($this->paginate))
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message
        ]);
    }

    public function filter(Request $request, $filters = null){

        $filters = json_decode($request->input('filters'));
        
        $query = $this->faq->query();

        if($filters != null){

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
    
            $query->when($filters->order, function ($q, $order) use ($filters) {
    
                $q->orderBy($order, $filters->direction);
            });
        }
    
        $faqs = $query->where('t_faqs.active', 1)
                ->orderBy('t_faqs.created_at', 'desc')
                ->paginate($this->paginate)
                ->appends(['filters' => json_encode($filters)]);   

        $view = View::make('admin.faqs.index')
            ->with('faqs', $faqs)
            ->renderSections();

        return response()->json([
            'table' => $view['table'],
        ]);
    }
}
