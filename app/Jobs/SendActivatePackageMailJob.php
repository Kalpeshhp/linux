<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\ActivePackageMail;
use Mail;

class SendActivatePackageMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $package;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($package)
    {
        $this->package = $package;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $arr =  $this->package;

        $data = [
            'package_name' => $arr['package_name'],
            'name' => $arr['name'],
            'price' => $arr['price'],
            'validity_years' => $arr['validity_years'],
        ];

        //print_r($data);
        //$users = User::where('id',$this->vendorId)->first();
        $name = new ActivePackageMail($data);

        Mail::to($arr['email'])->send($name);
    }
}
