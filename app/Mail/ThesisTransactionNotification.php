<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ThesisTransaction;

class ThesisTransactionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $recipient;

    public function __construct(ThesisTransaction $transaction, array $recipient)
    {
        $this->transaction = $transaction;
        $this->recipient = $recipient;
    }

    public function build()
    {
        return $this->view('emails.thesis-transaction')
                    ->subject('New Thesis Transaction Notification')
                    ->with([
                        'transaction' => $this->transaction,
                        'recipient' => $this->recipient
                    ]);
    }
} 