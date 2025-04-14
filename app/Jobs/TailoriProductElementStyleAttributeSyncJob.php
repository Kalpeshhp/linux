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
use App\Models\TailoriProductElementStyleAttributes;
use GuzzleHttp\Exception\ClientException;
class TailoriProductElementStyleAttributeSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $appKey;
    private $tailoriStyleCode;
    private $styleId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appKey, $tailoriStyleCode, $styleId)
    { 
        $this->appKey = $appKey;
        $this->tailoriStyleCode = $tailoriStyleCode;
        $this->styleId = $styleId;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{

            $client = new Client;
            
            $request = $client->get(Config::get('constants.TAILORI_PRODUCT_ELEMENT_STYLE_ATTRIBUTE_API_URL') . 'Key=' . $this->appKey . '&' . $this->tailoriStyleCode);
            
            $styleAttributes = json_decode($request->getBody()->getContents(), true);
            
            if ( $styleAttributes ) {
                foreach ($styleAttributes as $key => $value) {
                    TailoriProductElementStyleAttributes::updateOrCreate(['tailori_attribute_code' => $value], [
                        'style_id' => $this->styleId,
                        'tailori_attribute_code' => $value,
                        'attribute_name' => $key
                    ]);
                }
            }
        }
        catch(ClientException $e){
            Log::error($e);
        }
    }
}
