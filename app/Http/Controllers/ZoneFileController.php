<?php

namespace App\Http\Controllers;

use App\Models\ZoneFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZoneFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zonefiles = ZoneFile::all();
        return view('zonefile.index', compact('zonefiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('zonefile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        	'title' => 'required|unique:zone_files|max:255',
        	'source' => 'required|max:255',
        	'content' => 'required'
        ]);

        try {
        	$zoneFile = new ZoneFile($validatedData);

        	// Force imported to false
        	$zoneFile->imported = false;
        	$zoneFile->save();
        } catch ( \Exception $e ) {
        	throw $e;
        	Log::debug("Zonefile error: " . print_r($e->getMessage(), true));
        	return back()->withInput(); //->withErrors();
        }

        return redirect()->back(); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function show(ZoneFile $zonefile)
    {
        return view('zonefile.show', compact('zonefile'));
    }
}
