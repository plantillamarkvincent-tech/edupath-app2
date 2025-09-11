<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(string $to, string $message): void
    {
        // Placeholder: integrate with actual SMS provider here (e.g., Twilio/Vonage)
        Log::info('SMS to '.$to.': '.$message);
    }
}


