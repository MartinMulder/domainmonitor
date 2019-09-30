<?php

namespace App\Http\Controllers;

use App\Models\ZoneFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Differ;
use Jfcherng\Diff\Factory\RendererFactory;

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
        $latestTwo = $zonefiles->take(-2);
        $diff = $this->makeDiff($zonefiles->first(), $latestTwo->last(), 'Unified');
        if (empty($diff)) {
            $diff = 'No changes';
        } 
        return view('zonefile.index', compact('zonefiles', 'diff','latestTwo'));
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ZoneFile  $zonefile
     * @return \Illuminate\Http\Response
     */
    public function edit(ZoneFile $zonefile)
    {
        return view('zonefile.edit', compact('zonefile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ZoneFile  $zonefile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ZoneFile $zonefile)
    {
    	$zf = ZoneFile::find($zonefile->id);

        $validatedData = $request->validate([
        	'content' => 'required'
        ]);
        try {
        	// Force imported to false
        	//$zoneFile->imported = false;
        	$zf->content = $request->input('content');
        	$zf->save();
        } catch ( \Exception $e ) {
        	throw $e;
        	Log::debug("Zonefile error: " . print_r($e->getMessage(), true));
        	return back()->withInput(); //->withErrors();
        }

        return redirect('zonefile.show'); 
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

    public function diff(ZoneFile $old, ZoneFile $new) 
    {
    	$diff = $this->makeDiff($old, $new);
		return view('zonefile.diff', compact('diff','old', 'new'));
    }

    private function makeDiff(ZoneFile $old, ZoneFile $new, $renderName = 'Inline') 
    {
        // renderer class name: Unified, Context, Json, Inline, SideBySide
        $rendererName = $renderName;

        $differOptions = [
            // Show how many neighbor lines
            'context' => 3,
            // ignore case differance
            'ignoreCase' => false,
            // ignore whitespace differance
            'ignoreWhitespace' => false,
        ];

        $rendererOptions = [
            // how detailed the rendered HTML in-line diff is? (none, line, word, char)
            'detailLevel' => 'line',
            // renderer language: eng, cht, chs, jpn, ...
            // or an array which has the same keys with a language file
            'language' => 'eng',
            // show a separator between different diff hunks in HTML renderers
            'separateBlock' => true,
            // the frontend HTML could use CSS "white-space: pre;" to visualize consecutive whitespaces
            // but if you want to visualize them in the backend with "&nbsp;", you can set this to true
            'spacesToNbsp' => true,
            // HTML renderer tab width (negative = do not convert into spaces)
            'tabSize' => 4,
            // internally, ops (tags) are all int type but this is not good for human reading.
            // set this to "true" to convert them into string form before outputting.
            'outputTagAsString' => true,
            // extra HTML classes added to the DOM of the diff container
            'wrapperClasses' => ['diff-wrapper'],
        ];

        // one-line simply compare two strings
        //$result = DiffHelper::calculate($old->content, $new->content, $rendererName, $differOptions, $rendererOptions);

        // custom usage
        $differ = new Differ(explode("\n", $old->content), explode("\n", $new->content), $differOptions);
        $renderer = RendererFactory::make($rendererName, $rendererOptions); // or your own renderer object
        return $renderer->render($differ);
    }
}
