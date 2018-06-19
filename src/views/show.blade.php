@extends('formcinch::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{$form->title}}
        </h1>
    </section>
@endsection

@section('content')

    <form action="/form/{{$form->slug}}" method="POST">
        {{csrf_field()}}
        @include('formcinch::inc.notification')
        @foreach($form->fields as $key => $field)
            @if(is_array($field))
                <label for="{{$key}}">{{ucfirst($key)}}</label>
                <select class="form-control" name="{{$key}}" {{form_field_required($key, $form)}}>
                @if($field[0] === 'select')
                    @foreach($field[1] as $key => $option)
                        <option value="{{$option}}">{{$option}}</option>
                    @endforeach
                @endif
                </select>
            @elseif($field === 'text')
                <label for="{{$key}}" class="{{form_field_required($key, $form)}}"> {{ucfirst($key)}}</label>
                <input type="text" name="{{$key}}" class="form-control" {{form_field_required($key, $form)}} value="{{old($key)}}">
            @else($field === 'textarea')
                <label for="{{$key}}">{{ucfirst($key)}}</label>
                <textarea class="form-control" name="{{$key}}">{{old($key)}}</textarea>
            @endif
        @endforeach

        @if($form->recaptcha)
            @include('formcinch::inc.captcha')
        @endif

        <button class="btn btn-dark" type="submit">Submit</button>

    </form>

@endsection