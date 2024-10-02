<?php

namespace App\Console\Commands;

use App\Mail\TransactionStatusChanged;
use App\Models\Emailing;
use App\Models\Office;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendTransactionEmails extends Command implements ShouldQueue // Implement ShouldQueue
{

    use Queueable; // Use Queueable trait



    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-transaction-emails {transaction_ids*}'; // Accept transaction IDs as arguments

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send transaction emails to employees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ibu_dbcon = DB::connection('ibu_test');

        $transactionIds = $this->argument('transaction_ids');

        $transactions = Transaction::with(['honorarium', 'office'])
            ->whereIn('id', $transactionIds)
            ->get();

        foreach ($transactions as $transaction) {
            $employee = $ibu_dbcon->table('employee_user')
                ->where('id', $transaction->employee_id)
                ->first();

            $employeedetails = $ibu_dbcon->table('employee')
                ->where('id', $transaction->employee_id)
                ->first();

            if (!empty($employee->email)) {
                $emailData = [
                    'transaction_id' => $transaction->id,
                    'employee_fname' => $employeedetails->employee_fname,
                    'employee_lname' => $employeedetails->employee_lname,
                    'status' => 'On Queue',
                    'created_at' => now()->format('F j, Y'),
                    'honorarium' => $transaction->honorarium->name,
                    'office' => $transaction->office->name,
                ];

                Mail::to($employee->email)->send(new TransactionStatusChanged($emailData));
                sleep(1);
            }

            $email = new Emailing();
            $email->transaction_id = $transaction->id;
            $email->subject = 'Transaction Processing';
            $email->to_user = $employeedetails->id;
            $email->message = 'Your transaction is to be acknowledged by the budget office. Please wait for further updates.';
            $email->status = 'Unread';
            $email->created_by = $transaction->created_by;
            $email->save();
        }

        $this->info('Emails sent successfully.');
    }
}
