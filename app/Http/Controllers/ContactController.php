<?php

namespace App\Http\Controllers;

use App\Mail\ContactForm;
use App\Setting;

use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function mail()
    {
      $target = Setting::all('email');

      $attributes = request()->validate([
        'sender' => ['required'],
        'content' => ['required'],
        'email' => ['required']
      ]);

      \Mail::to($target)->send(
        new ContactForm($attributes)
      );

      return response()->json(['message'=> 'Success']);

    }
}
