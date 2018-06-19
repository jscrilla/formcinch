@component('mail::message')
# {{$submission->form->title}} form at {{$submission->form->path}} received a new submission"

@component('mail::table')
| Field         | Entry         |
| :------------- |:-------------|
@foreach($submission->results as $key => $result)
|{{$key}}|{{$result}}|
@endforeach
@endcomponent

@component('mail::button', ['url' => $submission->form->path])
View all submissions
@endcomponent

Thanks,<br>
{{ config('formcinch.formcinch.project_name') }}
@endcomponent
