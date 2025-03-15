<?php

namespace App\Console\Commands;

use App\Mail\ExpiredOfferNotification;
use App\Models\Offer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckExpiredOffers extends Command
{
    protected $signature = 'offers:check-expired';
    protected $description = 'Check for expired offers and send notifications';

    public function handle()
    {
        $currentDate = now();

        $expiredOffers = Offer::where('expiry_date', '<', $currentDate)->get();

        foreach ($expiredOffers as $offer) {
            $notifyTo = json_decode($offer->notify_to, true);

            foreach ($notifyTo as $email) {
                Mail::to($email)->send(new ExpiredOfferNotification($offer));
            }

        }

        $this->info('Expired offers notifications sent successfully.');
    }
}
