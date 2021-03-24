<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\DB\Faq;

class FaqController extends Controller
{
    protected $faq;

    function __construct(Faq $faq)
    {
        $this->faq = $faq;
    }

    public function index()
    {

        $view = View::make('admin.faqs.index')->with('faq', $this->faq);

        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }

        return $view;
    }

    public function indexJson()
    {
        if (! Auth::guard('web')->user()->canAtLeast(['faqs'])){
            return Auth::guard('web')->user()->redirectPermittedSection();
        }

        $query = $this->faq
        ->with('category')
        ->select('t_faq.*');

        return $this->datatables->of($query)->toJson();   
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
            'title' => request('title'),
            'description' => request('description'),
            'active' => 1,
        ]);

        $view = View::make('admin.faqs.index')
        ->with('faq', $faq)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $faq->id,
        ]);
    }

    public function show(Faq $faq)
    {
        if (! Auth::guard('web')->user()->canAtLeast(['faqs','edit'])){
            return Auth::guard('web')->user()->redirectPermittedSection();
        }
      
        $this->locale->setParent(slug_helper($faq->category->name));
        $locale = $this->locale->show($faq->id);

        $view = View::make('admin.faqs.index')
        ->with('faq', $faq)
        ->with('locale', $locale)
        ->with('crud_permissions', $this->crud_permissions);   
        
        if(request()->ajax()) {
            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy(Faq $faq)
    {
        if (! Auth::guard('web')->user()->canAtLeast(['faqs','remove'])){
            return Auth::guard('web')->user()->redirectPermittedSection();
        }

        $faq->delete();
        $this->locale->setParent(slug_helper($faq->category->name));
        $this->locale->delete($faq->id);

        $message = \Lang::get('admin/faqs.faq-delete');

        $view = View::make('admin.faqs.index')
            ->with('faqs', $this->faq->get())
            ->with('crud_permissions', $this->crud_permissions)
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message,
        ]);
    }

    public function reorderTable(Request $request)
    {
        $order = request('order');

        if (is_array($order)) {
            
            foreach ($order as $index => $tableItem) {
                $item = $this->faq->findOrFail($tableItem);
                $item->order = $index + 1;
                $item->save();
            }
        }
    }
}
