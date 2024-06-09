@extends('layouts.admin')

@section('content')
    <div class="row">
        <h1>Panel Principal</h1>
    </div>
    <hr>
    <div class="row">

         @can('usuarios.index')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    @php $contador_de_usuarios=0; @endphp
                    @foreach($usuarios as $usuario)
                        @php $contador_de_usuarios++; @endphp
                    @endforeach
                    <h3>{{$contador_de_usuarios}}</h3>
                    <p>Usuarios registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="{{url('/admin/usuarios')}}" class="small-box-footer">
                    Más información  <i class="bi bi-cloud-arrow-up-fill"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    @php $contador_de_carpetas=0; @endphp
                    @foreach($carpetas as $carpeta)
                        @php $contador_de_carpetas++; @endphp
                    @endforeach
                    <h3>{{$contador_de_carpetas}}</h3>
                    <p>Total de Carpetas Creadas</p>
                </div>
                <div class="icon">
                    <i class="fas"><i class="bi bi-folder-fill"></i></i>
                </div>
                <a href="" class="small-box-footer">
                    <i class="bi bi-check-circle-fill"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-light">
                <div class="inner">
                    @php $contador_de_archivos=0; @endphp
                    @foreach($archivos as $archivo)
                        @php $contador_de_archivos++; @endphp
                    @endforeach
                    <h3>{{$contador_de_archivos}}</h3>
                    <p>Total de Archivos Creados</p>
                </div>
                <div class="icon">
                    <i class="fas"><i class="bi bi-file-earmark-check-fill"></i></i>
                </div>
                <a href="" class="small-box-footer">
                   <i class="bi bi-check-circle-fill"></i>
                </a>
            </div>
        </div>

        @endcan

    </div>

@endsection
