@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
          <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
          {{ csrf_field() }}   <!--protege a solicitud de falsificaion de identidad -->
              <div class="card-body">
              <h1>Acceder</h1>
              <p class="text-muted">Control de acceso al sistema</p>
              <div class="form-group mb-3{{$errors->has('usuario' ? 'is-invalid' : '')}}">  <!--si el usuario no existe, se invalida ese campo -->
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}   <!-- aqui es donde se muestra q el usuario no existe-->
              </div>
              <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="row">
                <div class="col-6">
                  <button type="submit" class="btn btn-primary px-4">Acceder</button>
                </div>
              </div>
            </div>
          </form>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                  <h2>Sistema de Ventas</h2>
                  <p>Sistema de compras, ventas desarrollado por: Tec. Junior Y. Campos Alvarez <p>
                  <p>Para la Empresa "ABC" S.A.C.</p>
                  <img src="img/foto.jpg" alt="" width="25%">
                  <br>
                  <a href="https://www.facebook.com/junior.camposalvarez" target="_blank" class="btn btn-primary active mt-3">Ver!</a>
              </div>
              <footer >                  
              Consultas:<abbr title="Celular"> 935 910 409</abbr> <br>                    
              </footer>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
