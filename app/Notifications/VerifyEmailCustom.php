<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;


class VerifyEmailCustom extends Notification
{
    use Queueable;

    protected $admin;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $admin
     * @return void
     */
    public function __construct($admin)
    {
        $this->admin = $admin;  // Store the admin user to generate the verification link
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];  // Specify that the notification will be sent by mail
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = route('verification.verify.admin', [
            'id' => $this->admin->getKey(),
            'hash' => sha1($this->admin->getEmailForVerification())
        ]);
    
        $signedVerificationUrl = URL::signedRoute('verification.verify.admin', [
            'id' => $this->admin->getKey(),
            'hash' => sha1($this->admin->getEmailForVerification())
        ]);
    
        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email', $signedVerificationUrl);
    }
    

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            // Optionally, add more information about the notification here.
        ];
    }
}
