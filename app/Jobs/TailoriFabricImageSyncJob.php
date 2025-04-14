<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Fabric;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Config, Log;

class TailoriFabricImageSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $appKey;
    private $tailoriFabricId;
    private $recordId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appKey, $tailoriFabricId, $recordId)
    {
        $this->appKey = $appKey;
        $this->tailoriFabricId = $tailoriFabricId;
        $this->recordId = $recordId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        $fabrics = Fabric::all()->toArray();
        
        $imageTypes = ['thumbnail' => 't' ];

        $options = [
            'curl' => [
                CURLOPT_TCP_KEEPALIVE => 10,
                CURLOPT_TCP_KEEPIDLE => 10
            ]
        ];
        
        foreach($imageTypes as $key=>$value){
            $url = Config::get('constants.SWATCH_IMAGE_API_URL') . 'Key=' . $this->appKey . '&' . $this->tailoriFabricId . '&' . $value;
            $client = new Client;
            $request = $client->request('GET', $url, $options);
            $name = $key.'/'.$this->tailoriFabricId . '.png';
            $store = Storage::put($name, $request->getBody()->getContents());
            Log::info('Fabric ID : ' .$key. '--->' . $this->tailoriFabricId . PHP_EOL);
        }
        echo $this->recordId .' ===> '. $this->tailoriFabricId . PHP_EOL;
    }
}
