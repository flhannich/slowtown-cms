@component('mail::message')
# New Task!

For:
{{ $project->title }} <br><br>
Message:
{{ $task }}


@component('mail::button', ['url' => '/dashboard/projects/' . $project->id . '/edit'])
  View Project
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
