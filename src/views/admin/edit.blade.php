@extends('formcinch::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ config('formcinch.formcinch.project_name') }}<small>  Create Form</small>
        </h1>
    </section>
@endsection


@section('content')
        <div class="row">
            <div class="col-lg-8">
            <div class="box box-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('Add fields to your form') }}</div>
                    <div style="margin-bottom: 20px; clear: both;"></div>
                </div>

                    <form action="{{config('formcinch.formcinch.form_admin_prefix')}}/{{$form->id}}/edit" method="post">
                        {{ method_field('PUT') }}
                        {{csrf_field()}}

                        <div class="input-group well">
                            <select id="adder" class="form-control">
                                <option value="default" disabled selected>Select the field type </option>
                                <option value="text">Text </option>
                                <option value="textarea">Textarea</option>
                                <option value="select">Select List</option>
                                <option value="checkbox">Checkbox</option>
                            </select>
                            <span class="input-group-addon"></span>
                            <input type="text" id="adder-name" value="" class="form-control" placeholder="Field name">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="selected()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </span>
                        </div>

                        <fieldset>
                            <legend>
                                Form fields
                            </legend>
                        </fieldset>
                        <div id="require-msg" class="alert alert-warning" >
                            <i class="far fa-hand-point-right"></i>
                            Use the checkbox next the field to require it on submit.</div>
                        <div id="anchor" class="col-md-12 all-fields"><span id="anchor-msg"></span>

                            @foreach($form->fields as $key => $field)
                                @if(is_array($field))
                                    <div class="clearfix"></div>
                                    <label for="{{$key}}_select">{{ucfirst($key)}}</label>
                                @if($field[0] === 'select')
                                    @foreach($field[1] as $k => $option)
                                        <div class="input-group col-md-offset-1">
                                            <input type="text" name="{{$key}}_select_option[]" value="{{$option}}" class="form-control" placeholder="Option value">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button" onclick="addOption(this)"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            </span>
                                        </div>
                                        <div class="select-anchor" data-name="{{$key}}"></div>
                                    @endforeach
                                @endif
                                @elseif($field === 'text')
                                    <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="{{$key}}_required" aria-label="Checkbox for requiring this input" @if(array_key_exists($key, $form->required_fields)) checked @endif>
                                        </div>
                                    </div>
                                    <input type="text" name="{{$key}}_{{$field}}" class="form-control" {{form_field_required($key, $form)}} value="{{old($key)}}" placeholder="{{ucfirst($key)}}" readonly>
                                    </div>
                                @else($field === 'textarea')
                                    <label for="{{$key}}">{{ucfirst($key)}}</label>
                                    <textarea class="form-control" name="{{$key}}_{{$field}}" readonly>{{old($key)}}</textarea>
                                    <input type="checkbox" name="{{$key}}_required" aria-label="Checkbox for requiring this input" @if(array_key_exists($key, $form->required_fields)) checked @endif>
                                @endif
                            @endforeach


                        </div>
                        <div style="margin-bottom: 20px; clear: both;"></div>
                        <div class="clearfix"></div>


                        <fieldset>
                            <legend>Form Settings</legend>
                        </fieldset>
                        <div class="form-group">
                            <label for="slug" class="control-label {{formcinch_required('title')}}">Form Title</label>
                            <input type="text" name="title" value="{{ old('title', $form->title) }}" class="form-control" {{formcinch_required('title')}}>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label {{formcinch_required('slug')}}">Form url slug (leave blank to auto-generate)</label>
                            <input type="text" name="slug" value="{{ old('slug', $form->slug) }}" class="form-control" {{formcinch_required('slug')}}>
                        </div>

                        <div class="form-group">
                            <label for="confirmation_message" class="control-label {{formcinch_required('confirmation_message')}}">Confirmation message</label>
                            <textarea class="form-control" {{formcinch_required('confirmation_message')}}>{{ old('confirmation_message', $form->confirmation_message) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="emails" class="control-label {{formcinch_required('emails')}}">Email submissions to (comma separated)</label>
                            <input type="text" name="emails" value="{{ old('emails', $form->printEmails()) }}" class="form-control" {{formcinch_required('emails')}}>
                        </div>

                        <div class="form-group">
                            <label for="after_submit">After submission</label>
                            <select id="after-submit" name="after_submit" class="form-control">
                                <option disabled selected>Select the what to do after successfully submitting this form </option>
                                <option value="back">Take user back to form with success message</option>
                                <option value="redirect">Redirect (will be asked for path)</option>
                            </select>

                            <div class="d-none">
                                <label>Redirect path (e.g. /form-success)</label>
                                <input type="text" name="redirect_to" value="" class="form-control" {{formcinch_required('redirect_to')}}>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="extends" class="control-label {{formcinch_required('extends')}}">Template extends</label>
                            <input type="text" name="extends" value="{{ old('extends', $form->extends) }}" class="form-control" {{formcinch_required('extends')}}>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" aria-label="Checkbox for following text input" {{formcinch_checked($form)}} name="recaptcha">
                                </div>
                            </div>
                            <label for="recaptcha" class="form-control" readonly aria-label="Text input with checkbox">Should this form use the recaptch service?</label>
                        </div>

                        <div class="form-group">
                            <button type="submit">Submit</button>
                        </div>
                    </form>
            </div>
        </div>

@endsection


