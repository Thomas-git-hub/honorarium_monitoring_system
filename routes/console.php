<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\ThesisTransaction;
use App\Jobs\SendTransactionEmailsJob;

Artisan::command('send:thesis-emails', function () {
    $transactions = ThesisTransaction::where('status', 'On Queue')
        ->whereNotNull('tracking_number')
        ->get();

    foreach ($transactions as $transaction) {
        SendTransactionEmailsJob::dispatch($transaction)->onQueue('emails');
    }
})->purpose('Send emails for thesis transactions');




