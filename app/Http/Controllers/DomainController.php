<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phois\Whois\Whois;
use Illuminate\Support\Facades\Http;
use File;

class DomainController extends Controller
{
    public function domainCheck(Request $request)
    {
    	//cek if submit
    	$domainUse = null;
    	$domains = null;
    	if ($request->domain != null) {
    		//cek domain with TLD
    		$arrayDomain = explode('.', $request->domain);
    		if (count($arrayDomain) < 2) {
    			$domain = $request->domain.'.com';
    		}

    		//cek domain availability
	    	$whois = new Whois($domain);
	    	$domainUse = collect([
	    		'domain' => $domain,
	    		'isAvailable' => $whois->isAvailable()
	    	]);
	    	$domainUse->all();

	    	//get suggest domain name with tld
    		$tld = json_decode(File::get('tld.json'));
    		foreach(array_rand($tld, 10) as $td){
	    		$whois = new Whois($request->domain.'.'.$tld[$td]);
	    		$domains [] = [
	    			'domain' => strtolower($request->domain.'.'.$tld[$td]),
	    			'isAvailable' => $whois->isAvailable()
	    		];
    		}
    	}
    	return view('domainCheck',compact('domainUse','domains'));
    }
}
