<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditlogs = AuditLog::all();

        return view('auditlog.index', compact('auditlogs'));
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
     * @param  \App\Models\AuditLog  $auditlog
     * @return \Illuminate\Http\Response
     */
    public function show(AuditLog $auditlog)
    {
        return view('auditlog.show', compact('auditlog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AuditLog  $auditlog
     * @return \Illuminate\Http\Response
     */
    public function edit(AuditLog $auditlog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuditLog  $auditlog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuditLog $auditlog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuditLog  $auditlog
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditLog $auditlog)
    {
        //
    }
}
