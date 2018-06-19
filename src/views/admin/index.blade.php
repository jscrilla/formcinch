@extends('formcinch::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ config('formcinch.formcinch.project_name') }}<small>{{ trans('Dashboard') }} </small>
        </h1>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
                <h2>{{ config('formcinch.formcinch.project_name') }} Forms<a class="btn btn-dark btn-sm float-right" href="/form-cinch/new"><i class="fas fa-plus"></i> Add a form</a></h2>

                <div class="box-body">

                    @if($forms === 'not setup')
                        <div class="alert alert-danger">The migrations need to be run to use this package. From the command line, run php artisan migrate</div>
                    @else
                        @if(!$forms->count())
                            <tr>
                                <div class="well text-center" colspan="4">There are no forms yet. <a class="btn btn-dark" href="/form-cinch/new"><i class="fas fa-plus"></i> Add a form</a></div>
                            </tr>
                        @else
                            <table class="table table-striped">
                                <tr>
                                    <th>
                                        Form Name
                                    </th>
                                    <th>
                                        Path
                                    </th>
                                    <th>
                                        Email Recipients
                                    </th>
                                    <th>
                                        Submission Count
                                    </th>
                                    <th>
                                        Edit
                                    </th>
                                </tr>
                                @foreach($forms as $form)
                                    <tr>
                                        <td>
                                            {{$form->title}}
                                        </td>
                                        <td>
                                            <a href="{{config('formcinch.formcinch.form_route_prefix')}}/{{$form->slug}}">{{$form->slug}}</a>
                                        </td>
                                        <td>
                                            {{$form->printEmails()}}
                                        </td>
                                        <td>
                                            <a class="btn btn-dark btn-sm" href="{{$form->path}}"><i class="far fa-eye"></i> {{$form->submissions()->count()}}</a>
                                        </td>
                                        <td>
                                            <a class="btn btn-dark btn-sm" href="/form-cinch/{{$form->id}}/edit"><i class="far fa-edit"></i> Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    @endif


                </div>
            </div>
        </div>
    </div>
@endsection
