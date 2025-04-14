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
use App\Models\TailoriProduct;

class TailoriProductSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $appKey;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appKey)
    {
        $this->appKey = $appKey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client;
    
        $request = $client->get(Config::get('constants.TAILORI_PRODUCT_API_URL').'Key='. $this->appKey);

        $products = json_decode($request->getBody()->getContents(), true);

        if($products){
            foreach($products as $key=>$value){
                $productStrArray = explode('-', $key);
                $productName = $productStrArray[1];
                TailoriProduct::updateOrCreate( ['tailori_product_code' => $value], [
                    'tailori_product_code' => $value,
                    'product_name' => $productName,
                ]);
            }
        }
    }
}
