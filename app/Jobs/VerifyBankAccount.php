<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyBankAccount implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $bank_account;

    public function __construct($bank_account)
    {
        $this->bank_account = $bank_account;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $response = $this->bank_account->verify(['amounts' => [33, 45]]);

            info($response);
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
