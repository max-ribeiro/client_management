<?php

namespace App\Services\Scheduler;

use App\Mail\WelcomeEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class TaskSchedulerService
{
    /**
     * Agenda o e-mail de boas-vindas para um novo contato
     * @param Model $recipient destinatário do email
     * @param int $delay tempo de espera em minutos até que o email seja enviado
     * 
     * @return void
     */
    public function scheduleWelcomeEmail(Model $recipient, int $timeDelay = 30): void
    {
        Mail::to($recipient->email)
            ->queue((new WelcomeEmail($recipient))->delay(now()->addMinutes($timeDelay)));
    }
}