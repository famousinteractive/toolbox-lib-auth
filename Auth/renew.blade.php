@extends('Layouts.login')

@section('content')

        @if(isset($error))
            <div class="alert alert-error">
                <ul>
                    <li>{{ $error }}</li>
                </ul>
            </div>
        @endif

            {!! Form::open(['route' => 'auth.renewPasswordStore']) !!}

            <div class="form-group form-group--required">
                <label class="form-label">{{ fitrans('auth.form.password') }}</label>
                <input type="password" class="input-field block-level" id="password" required name="password"/>
                <div class="color--grey">
                  <small>{{ fitrans('auth.form.min_chars') }}</small>
                </div>
            </div>

            <div class="form-group form-group--required">
                <label class="form-label">{{ fitrans('auth.form.password_confirmation') }}</label>
                <input type="password" class="input-field block-level" id="password_confirmation" required name="password_confirmation"/>
            </div>

            <input type="hidden" name="recoverHash" value="{{ $recoverHash }}" />

            <div class="form-group">
                <button type="submit" name="button" class="btn block-level btn--orange">{{ fitrans('auth.form.renew_button') }}</button>
            </div>

            {!! Form::close() !!}


@endsection
