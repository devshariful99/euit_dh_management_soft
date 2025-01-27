<?php

namespace App\Console\Commands;

use App\Jobs\SendExpiryEmails as JobsSendExpiryEmails;
use App\Models\ClientDomain;
use App\Models\ClientHosting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

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

        // Get the dates for 15 days and 30 days from now
        $fifteenDaysFromNow = Carbon::now()->addDays(15);
        $oneMonthFromNow = Carbon::now()->addDays(30);

        // Log the date calculation for reference
        Log::info('Fetching domains and hostings expiring on ' . $fifteenDaysFromNow . ' and ' . $oneMonthFromNow);

        // Fetch domains expiring in 15 and 30 days
        $domains = ClientDomain::with(['client'])
            ->whereDate('last_expire_date', $fifteenDaysFromNow)
            ->orWhereDate('last_expire_date', $oneMonthFromNow)->where('purchase_type', 1)
            ->get();

        // Log the domains that were fetched
        Log::info('Domains fetched for email dispatch:', ['domains' => $domains->pluck('id')->toArray()]);

        // Fetch hostings (change your query if needed)
        $hostings = ClientHosting::with(['client'])->whereDate('last_expire_date', $fifteenDaysFromNow)->orWhereDate('last_expire_date', $oneMonthFromNow)->get();
        // $hostings = ClientHosting::with(['client', 'renews'])->get();
        Log::info('Hostings fetched for email dispatch:', ['hostings' => $hostings->pluck('id')->toArray()]);

        try {
            // Dispatch the email jobs
            JobsSendExpiryEmails::dispatch($domains, $hostings);
            Log::info('Email dispatch job queued successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to dispatch email job: ' . $e->getMessage());
        }

        // Call queue worker to process the job immediately (optional)
        try {
            Log::info('Queue worker processing the jobs.');
            Artisan::call('queue:work', ['--once' => true]);
        } catch (\Exception $e) {
            Log::error('Failed to run queue worker: ' . $e->getMessage());
        }
        $this->info('Email sending job dispatched and processed successfully!');
        Log::info('Command finished execution.');

        return Command::SUCCESS;
    }
}