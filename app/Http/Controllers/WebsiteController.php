<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$websites = [];

        // Get all the HTTP based services
        $services = Service::http()->get();

        // Loop through the services and get al the dns entries pointing to it
        foreach ($services as $service)
        {
            //Log::debug('service: ' . $service->service_name . ' port: ' . $service->port);
            foreach($service->ip->dnsRecords as $record)
            {
                $url = $service->getScheme() .'://'. $record->getDnsName();
                if ($service->port != 80 && $service->port != 443)
                {
                    $url .= ':' . $service->port;
                } 

                $filename = 'screenshots/'.$record->getDnsName().'/'.$service->port.'.jpg';
                if(Storage::disk('public')->exists($filename)) 
                {
                    $fname = 'storage/'.$filename;
                } else {
                    $fname = 'storage/screenshots/no_image.png';
                }

                $websites[$filename] = ['url' => $url, 'image' => $fname];
            }
        }

        return view('website.index', compact('websites'));
    }
}
