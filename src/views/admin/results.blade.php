@extends('formcinch::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('Dashboard') }}<small>{{ trans('Form Cinch Admin Settings') }}</small>
        </h1>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title"><strong>{{ $form->title }}</strong> Form Results <a class="btn btn-sm btn-dark float-right" href="/form/{{$form->slug}}">View Form</a></div>
                </div>

                <div class="box-body">
                    <table class="table table-striped">
                        @php $count = 0; @endphp
                        @foreach($form->submissions as $submission)
                            <tr>
                                @foreach($submission->results as $heading => $row)
                                    @if(!$count)
                                        <th>{{$heading}}</th>
                                    @endif
                                @endforeach
                                @if(!$count)<th>Submitted at</th>@endif
                            </tr>
                        @php $count = 1; @endphp
                            <tr>
                                @foreach($submission->results as $heading => $row)
                                    <td>{{$row}}</td>
                                @endforeach
                                    <td>{{$submission->created_at->format('F j, Y g:ia')}}</td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
