<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Transaction;

class HalfDayCheckingTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_transaction:halfday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Secara otomatis check transaksi yang sudah diterima namun penerima tidak mengganti status transaksi menjadi selesai.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldDays = Carbon::now()->subDays(3);

        $check_transactions = Transaction::where('status', 5)
                    ->whereDay('updated_at', '=', $oldDays)
                    ->get();

        foreach ($check_transactions as $check_transaction) {
            $check_transaction->status = 1;
            $check_transaction->update();
        }

        $this->info('Sukses merubah semua status transaksi yang sudah diterima, menjadi selesai.');
    }
}
