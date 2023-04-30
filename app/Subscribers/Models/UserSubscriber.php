<?php

namespace App\Subscribers\Models;

use App\Events\Models\User\GuardianCode;
use App\Listeners\SendGuardianCodeEmail;
use Illuminate\Events\Dispatcher;

class UserSubscriber
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(GuardianCode::class, SendGuardianCodeEmail::class);
    }
}
