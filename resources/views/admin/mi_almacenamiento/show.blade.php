@extends('layouts.admin')

@section('content')
<!-- CONTENIDO DE LAS SUB CARPETAS -->

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />


<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">{{$carpeta->nombre}}</h1>
  </div>
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <!-- Button trigger modal -->
      <a href="{{url('/admin/mi_almacenamiento')}}" class="btn btn-default"><i class="bi bi-caret-left-fill"></i>Volver</a>

      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_cargar_archivos">
        <i class="bi bi-cloud-arrow-up-fill"></i>Subir Archivos
      </button>
      <!-- Modal para subir archivos-->
      <div class="modal fade" id="modal_cargar_archivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Nombre de la Carpeta</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{url('/admin/mi_almacenamiento/carpeta/upload')}}" method="post" class="dropzone" id="myDropzone" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <input type="text" value="{{$carpeta->id}}" name="id" hidden>
                <div class="fallback">
                  <input type="file" name="file" multiple />

                </div>

              </div>
              <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Crear Carpeta</button>
      </div> -->
            </form>
          </div>
        </div>
      </div>
      <script>
        Dropzone.options.myDropzone = {

          paramName: "file",
          dictDefaultMessage: "Arrasta y suelta los archivos aqui o haz click para seleccionar los archivos"
        };
      </script>




      <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">
        <i class="bi bi-folder-fill"></i>Nueva Carpeta
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Nombre de la Carpeta</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{url('/admin/mi_almacenamiento/carpeta/crear_subcarpeta')}}" method="post">
              @csrf
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="text" value="{{$carpeta->id}}" name="carpeta_padre_id" hidden>
                      <input type="text" value="{{Auth::user()->id}}" name="user_id" hidden>
                      <input type="text" class="form-control" name="nombre" required>
                    </div>

                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Crear Carpeta</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </ol>
  </div>
</div>
<hr>
<h5>Carpetas y Archivos</h5>
<hr>
<div class="row">
  @foreach ($subcarpetas as $subcarpeta)
  <div class="col-md-3">
    <div class="divcontent">
      <div class="row" style="padding: 10px">
        <div class="col-2" style="text-align:center">
          <i class="bi bi-folder-fill" style="font-size: 20pt; color:{{$subcarpeta->color}}"></i>
        </div>
        <div class="col-8" style="margin-top: 5px">
          <a href="{{url('/admin/mi_almacenamiento/carpeta',$subcarpeta->id)}}" style="color: black">
            {{$subcarpeta->nombre}}
          </a>

        </div>
        <div class="col-2" style="margin-top:5px; text-align: right; ">
          <div class="btn-group" role="group">
            <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-three-dots-vertical"></i>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_cambiar_nombre{{$subcarpeta->id}}">
                <i class="bi bi-pencil"></i> Cambiar Nombre
              </a>
              <a class="dropdown-item" href="#">
                <i class="bi bi-sliders"></i>
                Color de la Carpeta
                <div class="btn-group" role="group" aria-label="Basic example">
                  <form action="{{url('/admin/mi_almacenamiento/carpeta/colors')}}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="text" value="red" name="color" hidden>
                    <input type="text" value="{{$subcarpeta->id}}" name="id" hidden>
                    <button type="submit" style="background-color: white; border: 0px; ">
                      <i class="bi bi-droplet-fill" style="color: red;"></i>
                    </button>
                  </form>
                  <form action="{{url('/admin/mi_almacenamiento/carpeta/colors')}}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="text" value="blue" name="color" hidden>
                    <input type="text" value="{{$subcarpeta->id}}" name="id" hidden>
                    <button type="submit" style="background-color: white; border: 0px; ">
                      <i class="bi bi-droplet-fill" style="color: blue;"></i>
                    </button>
                  </form>
                  <form action="{{url('/admin/mi_almacenamiento/carpeta/colors')}}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="text" value="yellow" name="color" hidden>
                    <input type="text" value="{{$subcarpeta->id}}" name="id" hidden>
                    <button type="submit" style="background-color: white; border: 0px; ">
                      <i class="bi bi-droplet-fill" style="color: yellow;"></i>
                    </button>
                  </form>
                  <form action="{{url('/admin/mi_almacenamiento/carpeta/colors')}}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="text" value="green" name="color" hidden>
                    <input type="text" value="{{$subcarpeta->id}}" name="id" hidden>
                    <button type="submit" style="background-color: white; border: 0px; ">
                      <i class="bi bi-droplet-fill" style="color: green;"></i>
                    </button>
                  </form>
                </div>


              </a>
              <a class="dropdown-item" href="#"><i class="bi bi-trash"></i> Eliminar</a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- Modal para cambiar el nombre de la carpeta-->
  <div class="modal fade" id="modal_cambiar_nombre{{$subcarpeta->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nombre de la Carpeta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('/admin/mi_almacenamiento/carpeta')}}" method="post">
            @csrf
            @method('PUT')
            <input type="text" value="{{$subcarpeta->id}}" name="id" hidden>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="text" value="{{$subcarpeta->nombre}}" class="form-control" name="nombre" required>
                </div>

              </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach
</div>

<hr>

<table class="table table-responsive table-hover table-striped">
  <thead>
    <tr>
      <th>
        <center>Nro</center>
      </th>
      <th>
        <center>Nombre</center>
      </th>
      <th>
        <center>Fecha</center>
      </th>
      <th>
        <center>Acciones</center>
      </th>
    </tr>

  </thead>
  <tbody>
    @php
    $contador=0;
    @endphp
    @foreach($archivos as $archivo)
    <tr>
      <td style="text-align: center;">{{$contador=$contador+1}}</td>
      <td>
        <?php
        $nombre = $archivo->nombre;
        $extension = pathinfo($nombre, PATHINFO_EXTENSION);
        if ($extension == "jpg") { ?> <img src="{{url('/imagenes/iconos/2143344.png')}}" width="25px" alt=""> <?php }
         if ($extension == "pdf") { ?> <img src="{{url('/imagenes/iconos/179483.png')}}" width="25px" alt=""> <?php }
          if ($extension == "docx") { ?> <img src="{{url('/imagenes/iconos/icono_de_word.png')}}" width="25px" alt=""> <?php }
         if ($extension == "mp4") { ?> <img src="{{url('/imagenes/iconos/465811611.png')}}" width="25px" alt=""> <?php }
         if ($extension == "mp3") { ?> <img src="{{url('/imagenes/iconos/540240200.png')}}" width="25px" alt=""> <?php }
                                                                                                                  ?>
        <a href="" data-toggle="modal" data-target="#modal_visor{{$archivo->id}}" style="color: black">
          {{$archivo->nombre}}
        </a>
        <?php if ($extension == "jpg") { ?>
          <!-- Modal -->
          <div class="modal fade" id="modal_visor{{$archivo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{$archivo->nombre}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="text-align: center;">
                  <img src="{{asset('storage/'.$carpeta->id.'/'.$archivo->nombre)}}" width="100%" alt="">

                </div>
              </div>
            </div>
          </div>
        <?php } ?>


        <?php if ($extension == "pdf") { ?>
          <!-- Modal -->
          <div class="modal fade" id="modal_visor{{$archivo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{$archivo->nombre}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="text-align: center;">
                  <iframe src="{{asset('storage/'.$carpeta->id.'/'.$archivo->nombre)}}" width="100%" height="600px" alt=""> </iframe>

                </div>
              </div>
            </div>
          </div>
        <?php } ?>


        <?php if ($extension == "docx") { ?>
          <!-- Modal -->
          <div class="modal fade" id="modal_visor{{$archivo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{$archivo->nombre}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="text-align: center;">
                  <img src="{{url('/imagenes/iconos/icono_de_word.png')}}" width="50%" alt=""> <br><br>
                  <a href="{{asset('storage/'.$carpeta->id.'/'.$archivo->nombre)}}" class="btn btn-success">
                    DESCARGAR
                  </a>

                </div>
              </div>
            </div>
          </div>
        <?php } ?>

        <?php if ($extension == "mp4") { ?>
          <!-- Modal -->
          <div class="modal fade" id="modal_visor{{$archivo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{$archivo->nombre}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="text-align: center;">
                  <video width="100%" height="600px" controls>
                    <source src="{{asset('storage/'.$carpeta->id.'/'.$archivo->nombre)}}" type="video/mp4">
                    Tu navegador no soporta la reproducción de video.
                  </video>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>


        <?php if ($extension == "mp3") { ?>
          <!-- Modal -->
          <div class="modal fade" id="modal_visor{{$archivo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{$archivo->nombre}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="text-align: center;">
                  <audio controls style="width: 100%;">
                    <source src="{{asset('storage/'.$carpeta->id.'/'.$archivo->nombre)}}" type="audio/mpeg">
                    Tu navegador no soporta la reproducción de audio.
                  </audio>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>




      </td>
      <td>{{$archivo->created_at}}</td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic example">
          <!-- Botón para eliminar -->
          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal_eliminar_archivo{{$archivo->id}}">
            <i class="bi bi-trash"></i>
          </button>

        </div>


        <!-- Modal de confirmación de eliminación de archivo -->
        <div class="modal fade" id="modal_eliminar_archivo{{$archivo->id}}" tabindex="-1" aria-labelledby="modalEliminarArchivoLabel{{$archivo->id}}" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarArchivoLabel{{$archivo->id}}">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este archivo?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form action="{{ route('mi_almacenamiento.archivo.eliminar_archivo', ['id' => $archivo->id]) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
              </div>
            </div>
          </div>
        </div>



        <!-- Botón para compartir -->
        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_compartir_{{$archivo->id}}"> <i class="bi bi-share-fill"></i></button>


        <!-- Modal -->
        <div class="modal fade" id="modal_compartir_{{$archivo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Compartir Archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>{{$archivo->nombre}}</p>
                <?php
                if (($archivo->estado_archivo) == "PRIVADO") { ?>

                  <b>Este Archivo esta de forma PRIVADA</b> <br> <br>
                  <form action="{{route('mi_almacenamiento.archivo.cambiar.privado.publico')}}" method="get">
                    @csrf
                    <input type="text" name="id" value="{{$archivo->id}}" hidden>
                    <button type="submit" class="btn btn-outline-success">Cambiar a Público</button>
                  </form>
                <?php
                } else { ?>
                  <b>Este arhivo esta de forma PÚBLICA </b> <br> <br>
                  <form action="{{route('mi_almacenamiento.archivo.cambiar.publico.privado')}}" method="post">
                    @csrf
                    <input type="text" name="id" value="{{$archivo->id}}" hidden>
                    <button type="submit" class="btn btn-outline-info">Cambiar a Privado</button>
                  </form>

                  <hr>
                  <button data-clipboard-target="#foo{{$archivo->id}}" type="button" class="btn btn-primary">Copiar Enlace</button>
                  <input type="text" id="foo{{$archivo->id}}" value="{{asset('storage/'.$carpeta->id.'/'.$archivo->nombre)}}" class="form-control">
                  <script>
                    var clipboard = new Clipboard('.btn'); </script>
                  <br>
                  <center>
                  <div id="qrcode{{$archivo->id}}"></div>                
                  </center>
                  <script>
                    var opciones = {
                      width: 150, //ancho del codigo qr
                      height: 150 //alto del codigo qr
                    };
                    //texto o URL que se convertira en codigo qr
                    var texto = "{{asset('storage/'.$carpeta->id.'/'.$archivo->nombre)}}";
                    // generar el codigo qr con las opciones de configuracion
                    var qrcode = new QRCode("qrcode{{$archivo->id}}", opciones);
                    qrcode.makeCode(texto); // Convertir el texto en codigo qr
                  </script>


                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        </div>
        </div>
    </tr>
    @endforeach
  </tbody>
</table>




@endsection