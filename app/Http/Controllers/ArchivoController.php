<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Str;

class ArchivoController extends Controller
{
    public function token(){
        $client_id=\Config('service.google.client_id');   
        $client_secret=\Config('service.google.client_secret');   
        $refresh_token=\Config('service.google.refresh_token');   
        $response=Http::post('https://oauth2.googleapis.com/token',[
            'client_id'=>$client_id,
            'client_secret'=>$client_secret,
            'refresh_token'=>$refresh_token,
            'grant_type'=>'refresh_token',
        ]);

        $accessToken=json_decode((string)$response->getBody(),true)['access_token'];
        return $accessToken;
    }

    public function store(Request $request){

        $validation=$request->validate([
            'file'=>'file|required',
            'file_name'=>'required'
        ]);    
        $accessToken=$this->token();
        //dd($accessToken);  
        $name=Str::slug($request->file->getClientOriginalName());
        $mime=$request->file->getClientMimeType();

        $response=Http::withHeaders([
            'Authorization'=>'Bearer'.$accessToken,
            'Content-type'=>'Aplication/json'
        ])->post('https://www.googleapis.com/drive/v3/files',[
            'data'=>$name,
            'mimeType'=>$mime,
            'uploadType'=>'resumable',
            'parents'=>[\Config('services.google.folder_id')],
        ]);

        if($response->successful()){
            return response('El Archivo se subio correctamente');
        }else{
            return response('Fallo al subir el Archivo');
        }
    }


    public function upload(Request $request)
    {
        $id = $request->id;
        $file = $request->file("file");
        $filename = time() . '-' . $file->getClientOriginalName();

        // Guardar archivo de forma PRIVADA en almacenamiento local se puede comentar
        $request->file('file')->storeAs($id, $filename);

        // Subir archivo a Google Drive
        $this->uploadToGoogleDrive($file, $filename);

        // Guardar información del archivo en la base de datos
        $archivo = new Archivo();
        $archivo->carpeta_id = $request->id;
        $archivo->nombre = $filename;
        $archivo->estado_archivo = 'PRIVADO';
        $archivo->save();

        return redirect()->back()
            ->with('mensaje', 'Se cargó el archivo de la manera correcta')
            ->with('icono', 'success');
    }

    private function uploadToGoogleDrive($file, $filename)
    {
        // Configuración del cliente de Google
        $client = new Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

        // Crear servicio de Google Drive
        $service = new Drive($client);

        // Metadatos del archivo
        $fileMetadata = new DriveFile([
            'name' => $filename,
            'parents' => [env('GOOGLE_DRIVE_FOLDER_ID')]
        ]);

        // Leer el contenido del archivo
        $content = file_get_contents($file->getPathname());

        // Subir archivo a Google Drive
        $uploadedFile = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        return $uploadedFile->id;
    }


        public function eliminar_archivo(Request $request){
           
            $id = $request->id;
            $archivo = Archivo::find($id);
            $estado_archivo = $archivo->estado_archivo;
            if($estado_archivo=='PRIVADO'){
                Storage::delete($archivo->carpeta_id.'/'.$archivo->nombre);
            }
            else{
                Storage::delete('public/'.$archivo->carpeta_id.'/'.$archivo->nombre);
            }
            Archivo::destroy($id);          
            return redirect()->back()
                ->with('mensaje', 'Se eliminó el archivo de la manera correcta')
                ->with('icono', 'success');
        }

        public function cambiar_de_privado_a_publico(Request $request){
            $id = $request->id;
            $estado_archivo = "PÚBLICO";

            $archivo = Archivo::find($id);
            $carpeta_id= $archivo->carpeta_id;
            $nombre= $archivo->nombre;


            $archivo->estado_archivo = $estado_archivo;
            $archivo->save();

            $ruta_archivo_privado = $carpeta_id.'/'.$nombre;

            $ruta_archivo_publico = 'public/'.$carpeta_id.'/'.$nombre;

            Storage::move($ruta_archivo_privado,$ruta_archivo_publico);

            return redirect()->back()
            ->with('mensaje', 'Se cambió el estado del Archivo')
            ->with('icono', 'success');

        }


         public function cambiar_de_publico_a_privado(Request $request){
            $id = $request->id;
            $estado_archivo ="PRIVADO";

            $archivo = Archivo::find($id);
            $carpeta_id= $archivo->carpeta_id;
            $nombre = $archivo->nombre;

            $archivo->estado_archivo = $estado_archivo;
            $archivo->save();   


            $ruta_archivo_privado = $carpeta_id.'/'.$nombre;

            $ruta_archivo_publico = 'public/'.$carpeta_id.'/'.$nombre;

            Storage::move($ruta_archivo_publico,$ruta_archivo_privado);

            return redirect()->back()
            ->with('mensaje', 'Se cambió el estado del Archivo')
            ->with('icono', 'success');


         }

   


}

