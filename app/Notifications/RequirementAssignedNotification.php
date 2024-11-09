<?php

namespace App\Notifications;

use App\Models\Requirement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequirementAssignedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Requirement $requirement)
    {
        $this->requirement = $requirement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Requirement Assigned')
            ->line('A new requirement has been assigned to you.')
            ->line('Requirement: ' . $this->requirement->name)
            ->line('Description: ' . $this->requirement->description)
            ->line('Due Date: ' . $this->requirement->due_date->format('Y-m-d'))
            ->action('View Requirement', route('user.requirements.show', $this->requirement->id))
            ->line('Thank you for your attention!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'requirement_id' => $this->requirement->id,
            'name' => $this->requirement->name,
            'description' => $this->requirement->description,
            'due_date' => $this->requirement->due_date,
        ];
    }
}
