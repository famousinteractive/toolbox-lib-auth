@extends('Layouts.login')

@section('content')

        @if(isset($success))

            <h1 class="text-center">{!! fitrans('auth.recoverPassword.title_success') !!}</h1>

            <div class="mb-lg">
              <svg class="icon icon--width">
                  <use xlink:href="#icon-flyer-green"></use>
              </svg>
            </div>

            <p class="mb-lg text-center">{!! fitrans('auth.recoverPassword.copy_done') !!}</p>

            <div class="form-group text-center">
                <a href="{{ route('auth.login') }}" class="btn btn--wide btn--orange">{{ fitrans('auth.form.go_to_login') }}</a>
            </div>
        @else

        <h1 class="text-center">{!! fitrans('auth.recoverPassword.h2') !!}</h1>

        <p class="mb-lg text-center">{!! fitrans('auth.recoverPassword.copy_lead') !!}</p>

        {!! Form::open(['route' => 'auth.recoverPasswordStore']) !!}

        <div class="form-group form-group--required">
            <label class="form-label">{{ fitrans('auth.form.email') }}</label>
            <input type="email" class="input-field block-level" required name="email"/>
        </div>

        <div class="form-group text-center">
            <button type="submit" name="button" class="btn btn--wide btn--orange">{{ fitrans('auth.form.recover_button') }}</button>
        </div>

        {!! Form::close() !!}

        @endif


@endsection
