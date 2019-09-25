<?php

namespace App\Jobs;

use App\Models\DnsRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExecuteScreenshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $url;
    private $dnsName;
    private $port;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $dnsName, $port)
    {
        $this->url = $url;
        $this->dnsName = $dnsName;
        $this->port = $port;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Call the google API to fetch JSON data
        $screen_shot_json_data = file_get_contents("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$this->url&screenshot=true&key=AIzaSyD4uFoZtoPsDU0AouIMbtUdopJY1IBKtC4e");

        // Decode JSON response in PHP array
        $screen_shot_result = json_decode($screen_shot_json_data, true);

        // Get the base64 image data
        $screen_shot = $screen_shot_result['screenshot']['data'];

        // String-replace some stuff
        // $screen_shot contains the base64 image source
        $screen_shot = str_replace(array('_','-'), array('/','+'), $screen_shot);

        // Save the image
        Storage::put('public/screenshots/' . $this->dnsName . '/' . $this->port . '.jpg', base64_decode($screen_shot));

        // Construct an image tag with the right data
        //$screen_shot_image = "<img src=\"data:image/jpeg;base64,".$screen_shot."\" class='img-responsive img-thumbnail' />";

    }
}
