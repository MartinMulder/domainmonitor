<?php

namespace App\Http\Controllers;

use App\Jobs\ExecuteReverseDnsLookup;
use App\Jobs\ExecutePortScan;
use App\Models\Ip;
use Illuminate\Http\Request;

class IpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ips = Ip::withCount('dnsrecords')->get();
        return view('ip.index', compact('ips'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function show(Ip $ip)
    {
        return view('ip.show', compact('ip'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function edit(Ip $ip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ip $ip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ip $ip)
    {
        //
    }

    public function doReverseDns(IP $ip)
    {
        $foo = ExecuteReverseDnsLookup::dispatch($ip);
        //return redirect()->back();
        /*
        $domains = Domain::whereNull('last_whois_date')->get();
        foreach($domains as $d) {
            ExecuteWhois::dispatch($d);
            sleep(5);
        }
        */
    }

    public function retryReverseDNS(IP $ip)
    {
        $foo = ExecuteReverseDnsLookup::dispatch($ip);
        return redirect()->back();
    }

    public function retryPortScan(IP $ip)
    {
        $foo = ExecutePortScan::dispatch($ip);
        return redirect()->back();
    }
}
