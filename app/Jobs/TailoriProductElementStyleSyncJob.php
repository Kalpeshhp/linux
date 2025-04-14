<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Config, Log;
use App\Models\TailoriProductelement;
use App\Models\TailoriProductElementStyle;
use GuzzleHttp\Exception\ClientException;

class TailoriProductElementStyleSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $appKey;
    private $tailoriElementCode;
    private $elementId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appKey, $tailoriElementCode, $elementId)
    {
        $this->appKey = $appKey;
        $this->tailoriElementCode = $tailoriElementCode;
        $this->elementId = $elementId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client;
        try{
            $request = $client->get(Config::get('constants.TAILORI_PRODUCT_ELEMENT_STYLE_API_URL') . 'Key=' . $this->appKey . '&' . $this->tailoriElementCode);
    
            $productElements = json_decode($request->getBody()->getContents(), true);
            
            if ($productElements) {
                foreach ($productElements as $key => $value) {
                    TailoriProductElementStyle::updateOrCreate(['tailori_style_code' => $value], [
                        'element_id' => $this->elementId,
                        'tailori_style_code' => $value,
                        'style_name' => $key
                    ]);
                }
            }
        }
        catch(ClientException $e){
            Log::error($e);
        }
    }
}
