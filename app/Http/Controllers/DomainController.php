<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phois\Whois\Whois;

class DomainController extends Controller
{
    public function domainCheck(Request $request)
    {
    	if ($request->domain != null) {
	    	$domain = new Whois($request->domain);
	    	$split_domain = explode('.', $request->domain);
    	}
    	return view('domainCheck');
    }
}
