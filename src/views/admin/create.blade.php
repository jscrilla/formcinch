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

                    <form action="{{config('formcinch.formcinch.form_admin_prefix')}}/new" method="post">
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
                        <div id="require-msg" class="alert alert-warning" style="display:none;">
                            <i class="far fa-hand-point-right"></i>
                            Use the checkbox next the field to require it on submit.</div>
                        <div id="anchor" class="col-md-12 all-fields"><span id="anchor-msg">Added fields will display here.</span></div>
                        <div style="margin-bottom: 20px; clear: both;"></div>
                        <div class="clearfix"></div>


                        <fieldset>
                            <legend>Form Settings</legend>
                        </fieldset>
                        <div class="form-group">
                            <label for="slug" class="control-label {{formcinch_required('title')}}">Form Title</label>
                            <input type="text" name="title" value="" class="form-control" {{formcinch_required('title')}}>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label {{formcinch_required('slug')}}">Form url slug (leave blank to auto-generate)</label>
                            <input type="text" name="slug" value="" class="form-control" {{formcinch_required('slug')}}>
                        </div>

                        <div class="form-group">
                            <label for="confirmation_message" class="control-label {{formcinch_required('confirmation_message')}}">Confirmation message</label>
                            <textarea class="form-control" {{formcinch_required('confirmation_message')}}></textarea>
                        </div>

                        <div class="form-group">
                            <label for="emails" class="control-label {{formcinch_required('emails')}}">Email submissions to (comma separated)</label>
                            <input type="text" name="emails" value="" class="form-control" {{formcinch_required('emails')}}>
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
                            <input type="text" name="extends" value="" class="form-control" {{formcinch_required('extends')}}>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" aria-label="Checkbox for following text input" name="recaptcha">
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


