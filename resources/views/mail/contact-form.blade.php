@component('mail::message')

<div>
  From: </br>{{ $sender }}
</div>
<div>
  E-mail: </br>{{ $email }}
</div>
<div>
  Message: </br>{{ $content }}
</div>


{{--
@component('mail::button', ['url' => '#'])
  View Project
@endcomponent --}}

@endcomponent
