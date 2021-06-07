<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vendor\Locale\Manager;
use App\Vendor\Image\Image;
use App\Vendor\Locale\Models\LocaleTag;
use App\Models\DB\BusinessInformation; 

class BusinessInformationController extends Controller 
{
    protected $manager;
    protected $locale_tag;
    protected $image;
    protected $business;

    function __construct(LocaleTag $locale_tag, Manager $manager, Image $image, BusinessInformation $business)
    {
        $this->middleware('auth');
        $this->manager = $manager;
        $this->locale_tag = $locale_tag;
        $this->image = $image;
        $this->business = $business;

        $this->image->setEntity('business_information');
    }

    public function index()
    {
        $business = $this->business->first();

        $informations = $this->locale_tag
        ->where('group', 'front/information')
        ->select('key','value','language')
        ->get(); 

        foreach ($informations as $information){
            $key = $information->key . '.' . $information->language;
            $business[$key] = $information->value;
        }

        $view = View::make('admin.business_information.index')->with('business', $business);
  
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }

        return $view;
    }

    public function store(Request $request)
    {    
    
        foreach (request('business') as $key => $value){

            $key = str_replace(['-', '_'], ".", $key); 
			$explode_key = explode('.', $key);
			$key = reset($explode_key);
			$language = end($explode_key);

            $locale_tag = $this->locale_tag::updateOrCreate([
                'language' => $language,
                'group' => request('group'),
                'key' => $key],[
                'value' => $value,
                'active' => 1
            ]);
        }
        
        $this->manager->exportTranslations(request('group'));   

        if(request('images')){

            $images = $this->image->store(request('images'), 1);
        }

        $business = $this->business->first();

        $informations = $this->locale_tag
        ->select('group', 'key')
        ->groupBy('group', 'key')
        ->where('group', 'like', 'front/information')
        ->get();  

        foreach ($informations as $information){
            $key = $information->key . '.' . $information->language;
            $business[$key] = $information->value;
        }
        
        $message = \Lang::get('admin/business-information.business-information-update');

        $view = View::make('admin.business_information.index')
        ->with('business', $business)
        ->renderSections(); 

        return response()->json([
            'form' => $view['form'],
            'message' => $message,
        ]);
    }
}
