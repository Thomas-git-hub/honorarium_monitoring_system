<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ThesisTransaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThesisTransactionNotification;
use Illuminate\Support\Facades\Log;

class SendTransactionEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction;
    public $tries = 3; // Number of retry attempts

    public function __construct(ThesisTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function handle()
    {
        $recipients = [
            [
                'email' => $this->transaction->adviser->email,
                'name' => $this->transaction->adviser->first_name . ' ' . $this->transaction->adviser->last_name,
                'role' => 'Adviser'
            ],
            [
                'email' => $this->transaction->chairperson->email,
                'name' => $this->transaction->chairperson->first_name . ' ' . $this->transaction->chairperson->last_name,
                'role' => 'Chairperson'
            ]
        ];

        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient['email'])
                    ->send(new ThesisTransactionNotification($this->transaction, $recipient));
            } catch (\Exception $e) {
                Log::error("Failed to send email to {$recipient['email']}: " . $e->getMessage());
                $this->release(30); // Release back to queue after 30 seconds
            }
        }
    }
} 