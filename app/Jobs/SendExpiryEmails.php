<?php

namespace App\Jobs;

use App\Mail\AdminERNotifyMail;
use App\Mail\ExpiryReminder;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendExpiryEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $domains;
    protected $hostings;
    /**
     * Create a new job instance.
     *
     * @param object $domains
     * @param object $hostings
     */
    public function __construct(object $domains, object $hostings)
    {
        $this->domains = $domains;
        $this->hostings = $hostings;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendEmails($this->domains, 'domain');
        $this->sendEmails($this->hostings, 'hosting');
    }

    private function sendEmails(object $items, string $type)
    {
        if ($items->isEmpty()) {
            Log::info("No $type's to send email");
            return;
        }
        $renewals = [];
        foreach ($items as $key => $item) {
            $data = [
                'client' => $item->client->name,
                'day' => Carbon::parse($item->last_expire_date)->diffInDays(Carbon::now()),
                'subject' => "$type Renewal Reminder",
                'email_for' => $type,
                'name' => $type == 'domain' ? $item->domain_name : $item->hosting->name,
                'storage' => $type == 'hosting' ? $item->storage : '',
                'email' => $item->client->email,
                'expire_date' => $item->last_expire_date
            ];
            $renewals[] = $data;

            // Mail::to($item->client->email)
            //     ->send(new ExpiryReminder($data));
            // sleep(5);
        }
        Mail::to('schwdhry@gmail.com')
            ->send(new AdminERNotifyMail($renewals));
        sleep(5);
        Mail::to('murasid@gmail.com')
            ->send(new AdminERNotifyMail($renewals));

        Log::info("$type's expiration reminder emais send successfully");
    }
}