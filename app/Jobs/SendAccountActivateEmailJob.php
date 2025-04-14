<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\ActivateAccountMail;
use App\User;
use Mail;

class SendAccountActivateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $vendorId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::where('id',$this->vendorId)->first();
        $name = new ActivateAccountMail($users->first_name);

        Mail::to($users->email)->send($name);
    }
}
