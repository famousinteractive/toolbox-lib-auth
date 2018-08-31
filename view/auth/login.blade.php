@extends('Layouts.login')

@section('content')

  @if(isset($autherror))
    <div class="alert alert-danger">
        <ul>
            <li>{{ $autherror }}</li>
        </ul>
    </div>
  @endif

  {!! Form::open(['route' => 'auth.loginStore']) !!}

    <div class="form-group form-group--required">
      <label class="form-label{{ isset($data['email']) ? ' form-label--active' : '' }}">{{ fitrans('auth.form.email') }}</label>
      <input type="email" class="input-field block-level" value="{{ isset($data['email']) ? $data['email'] : '' }}" required name="email"/>
    </div>

    <div class="form-group form-group--required">
      <label class="form-label">{{ fitrans('auth.form.password') }}</label>
      <input type="password" class="input-field block-level" required name="password"/>
    </div>

    <div class="form-group--no-input">
      <label class="input-checkbox">
        <input type="checkbox" name="stay_logged" value="1">{{ fitrans('auth.form.stay_logged_in') }}
      </label>
    </div>

    <input type="hidden" name="redirect" value="{{ $redirect }}" />

    <div class="form-group">
      <button type="submit" name="button" class="btn block-level btn--orange">{{ fitrans('auth.form.login_button') }}</button>
    </div>

  <p class="text-center">
    <a href="{{ route('auth.recoverPassword') }}" class="color--orange">{{ fitrans('auth.form.forgot_password') }}</a>
  </p>

  {!! Form::close() !!}


@endsection
