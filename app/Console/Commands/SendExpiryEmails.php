<?php

namespace App\Console\Commands;

use App\Jobs\SendExpiryEmails as JobsSendExpiryEmails;
use App\Models\ClientDomain;
use App\Models\ClientHosting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendExpiryEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:ExpiryReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for domains/hosting expiring in 30 days';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fifteenDaysFromNow = Carbon::now()->addDays(15);
        $oneMonthFromNow = Carbon::now()->addDays(30);

        // Fetch domains expiring in 10 days
        $domains = ClientDomain::with(['client', 'renews'])->whereDate('expire_date', $fifteenDaysFromNow)->orWhereDate('expire_date', $oneMonthFromNow)->get();

        $hostings = ClientHosting::with(['client', 'renews'])->whereDate('expire_date', $fifteenDaysFromNow)->orWhereDate('expire_date', $oneMonthFromNow)->get();

        $hostings = ClientHosting::with(['client', 'renews'])->get();
        JobsSendExpiryEmails::dispatch($domains, $hostings);
        $this->info('Email sending job dispatched successfully!');
        return Command::SUCCESS;
    }
}