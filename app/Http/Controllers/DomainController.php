<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Jobs\ExecuteWhois;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = Domain::all();

        return view('domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'domain' => 'required|unique:domains|max:255',
        ]);

        try {
            $domain = new Domain($validatedData);

            // Force imported to false
            $domain->in_bitportal = false;
            $domain->save();
        } catch ( \Exception $e ) {
            Log::debug("Domain error: " . print_r($e->getMessage(), true));
            return back()->withInput(); //->withErrors();
        }

        return redirect()->back(); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function show(Domain $domain)
    {
        return view('domains.show', compact('domain'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domain $domain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain)
    {
        //
    }

    public function doWhois(Domain $domain)
    {
        $foo = ExecuteWhois::dispatch($domain);
        dd($foo);
        /*
        $domains = Domain::whereNull('last_whois_date')->get();
        foreach($domains as $d) {
            ExecuteWhois::dispatch($d);
            sleep(5);
        }
        */
    }

    public function addRecord(Request $request, Domain $domain)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|max:5',
            'destination' => 'required|max:255',
            'ttl' => 'required|integer'
        ]);

        $result = $domain->dnsRecords()->updateOrCreate(
            // Define the unique fields to select the record
            [
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'destination' => $request->input('destination'),

            ],
            // Dynamic data
            [
                'ttl' => $request->input('ttl'),
                'imported_by_zonefile' => 0,
            ]
        );

        return redirect()->back();
    }
}
