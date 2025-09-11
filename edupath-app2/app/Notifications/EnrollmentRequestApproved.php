<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnrollmentRequestApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public array $data)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Enrollment Request is Approved')
            ->greeting('Hello ' . ($this->data['full_name'] ?? 'Student'))
            ->line('Your enrollment request for ' . ($this->data['program_name'] ?? 'your chosen program') . ' has been approved.')
            ->action('View Dashboard', url('/dashboard'))
            ->line('Thank you!');
    }
}


