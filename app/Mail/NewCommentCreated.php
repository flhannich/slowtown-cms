<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewCommentCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
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
        $this->comment = $comment['content'];
        $this->author = $comment['author'];
          // dd($task);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.new-comment-created');
    }
}
