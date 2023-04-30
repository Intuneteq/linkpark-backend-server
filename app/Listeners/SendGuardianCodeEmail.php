<?php

namespace App\Listeners;

use App\Events\Models\User\GuardianCode;
use App\Mail\GuardianCodeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendGuardianCodeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(GuardianCode $event): void
    {
        Mail::to($event->user)->send(new GuardianCodeMail($event->user, $event->guardian_code));
    }
}
