<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForeignTaskCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $project)
    {
        $this->project = $project;
        // $this->task = $task;
        $this->task = $task['description'];
          // dd($task);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.foreign-task-created');
    }
}
