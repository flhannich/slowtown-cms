@component('mail::message')
# New Comment!

For:
{{ $project->title }} <br><br>
Message:
{{ $comment }}
Author:
{{ $author }}


@component('mail::button', ['url' => '/cms/'])
  Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
