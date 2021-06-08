<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Requests\Front\ContactRequest;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Models\DB\ContactLog;
use App\Jobs\ContactEmail;

class ContactController extends Controller
{
    protected $agent;
    protected $contact_log;
    protected $locale_slug_seo;

    function __construct(Agent $agent, ContactLog $contact_log, LocaleSlugSeo $locale_slug_seo)
    {
        $this->agent = $agent;
        $this->contact_log = $contact_log;
        $this->locale_slug_seo = $locale_slug_seo;

        $this->locale_slug_seo->setLanguage(app()->getLocale()); 
        $this->locale_slug_seo->setParent('contact');      
    }

    public function index()
    {        
        $seo = $this->locale_slug_seo->getByKey(Route::currentRouteName());

        $view = View::make('front.pages.contact.index')->with('seo', $seo );
        
        return $view;
    }

    public function store(ContactRequest $request)
    {        
        $contact_log = $this->contact_log->create([
            'fingerprint' => $request->cookie('fp') ? $request->cookie('fp') : '',
            'name' => request('name'),
            'email' => request('email'),
            'message' => request('message'),
        ]);

        dispatch(new ContactEmail($contact_log))->onQueue('email');

        $message = \Lang::get('front/contact.success');

        return response()->json([
            'message' => $message
        ]);
    }
}
