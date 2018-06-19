{!! NoCaptcha::renderJs() !!}
<div class="form-group pt-3">
    {!! NoCaptcha::display() !!}

    @if ($errors->has('g-recaptcha-response'))
        <span class="help-block">
            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
        </span>
    @endif
</div>