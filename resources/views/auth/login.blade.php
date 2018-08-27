<div id="divlogin" class="center">
    <div class="right col s12 m4 l4 login hoverable">
        <div class="panel-default" id="panellogin">
            <div class="center white-text">Ingreso a la plataforma</div>
            @if ($errors->has('email'))
                <span class="help-block alert alert-info">
                   <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            @if ($errors->has('password'))
                <span class="help-block alert alert-info">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group input-field col s12 m10 l10{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="active white-text">E-Mail:</label>
                        <input id="email" type="email" placeholder="Ej: example@domain.com"
                               class="form-control white-text" name="email" value="{{ old('email') }}"
                               required
                               autofocus>
                    </div>

                    <div class="form-group input-field col s12 m10 l10{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="active white-text">Contraseña:</label>

                        <input id="password" type="password" class="form-control white-text" name="password"
                               required>
                    </div>

                    <div class="form-group col s12 m12 l12 left-align">
                        <input type="checkbox" id="remember" class="grey-text"
                               name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="white-text">Recordarme</label>
                    </div>

                    <div class=" col s12 m12 l12">
                        <div class="center">
                            <div class="col s12 m12 l12">
                                <button type="submit" class="btn light light-green">
                                    <span class="glyphicon glyphicon-send"></span>Ingresar
                                </button>
                                <br>
                                <a class="btn-link light white-text" href="#!"
                                   onclick="mostrarocultar('cancelar')"><span
                                            class="glyphicon glyphicon-remove"></span>Cancelar
                                </a>
                            </div>
                            <a class="btn-link white-text" href="{{ route('password.request') }}">
                                Olvidaste tu contraseña?
                            </a><br>
                            <a class="btn-link white-text" href="#!" onclick="mostrarocultar('registrar')">
                                No tienes cuenta? Registrate <strong>aquí</strong>.
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>