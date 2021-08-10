<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewIdeasPromotionMail extends Mailable
{
    use Queueable, SerializesModels;

    
    /**
     * Sujeto del mensaje
     *
     * @var String
     */
    public $subject;
    
    /**
     * Título del mensaje
     *
     * @var String
     */
    public $title;
    
    /**
     * Datos del mensaje
     *
     * @var String
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        $data,
        $subject = 'Notificación para la promoción ayuda a las nuevas ideas',
        $title = '¡La promoción se ha completado!'
    ) {
        $this->subject = $subject;
        $this->title   = $title;
        $this->data    = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('emails.NewIdeasPromotionMail');
    }
}
