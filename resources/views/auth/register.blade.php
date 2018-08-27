
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading center">Registro de acceso</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{\Illuminate\Support\Facades\Input::get('type')}}" name="type"
                                   id="type">
                            <div class="form-group{{ $errors->has('nombres') ? ' has-error' : '' }}">
                                <label for="nombres" class="col-md-4 control-label">Nombres:</label>

                                <div class="col-md-6">
                                    <input id="nombres" type="text" class="form-control" name="nombres"
                                           value="{{ old('nombres') }}" required autofocus>

                                    @if ($errors->has('nombres'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('nombres') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="apellidos" class="col-md-4 control-label">Apellidos:</label>

                                <div class="col-md-6">
                                    <input id="apellidos" type="text" class="form-control" name="apellidos"
                                           value="{{ old('apellidos') }}" required autofocus>

                                    @if ($errors->has('apellidos'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('apellidos') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('registeremail') ? ' has-error' : '' }}">
                                <label for="registeremail" class="col-md-4 control-label">E-Mail correo:</label>

                                <div class="col-md-6">
                                    <input id="registeremail" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Contraseña</label>

                                <div class="col-md-6">
                                    <input id="registerpassword" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('registerpassword'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('registerpassword') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirmar
                                    contraseña</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary light light-green">
                                        Registrame
                                    </button>
                                    <button class="btn btn-default" onclick="mostrarocultar('cancelar')">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
