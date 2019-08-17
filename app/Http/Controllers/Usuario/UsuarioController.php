<?php

namespace App\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Usuario;
use App\Models\Socio;
use App\Models\UsuarioRelSocio;
use App\Models\UsuarioRelEntidad;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{

  
    public function userxid($id,$token){
       
        /*
        //usando un sp
        $model= new Usuario();
                      
           $users = $model ->hydrate(
                DB::select('call pcLogin(?,?)',[$data->input('usrSistema'),$data->input('passwSistema')])
           );

           return $users;
        */



        /*
         // Pendiente de ver si creo un sp

        $user = Usuario::where('idUsuario',$id)->get();
        
        foreach($user as $usr)
        {  
            $arrayUsrs[]=[
                'idusuario'=>$usr->idUsuario,
                'usuario'=>$usr->usrSistema,
                'nombre' => $usr->nombre,
                'apPaterno' => $usr->apPaterno,
                'apMaterno' => $usr->apMaterno,
                'correo' => $usr->correo,
                'capoNombre' => $usr->capoNombre,
                'fechaNacimiento' => $usr->fechaNacimiento,
                'sexo' => $usr->sexo,
                'idClubFrecuentaMas' => $usr->idClubFrecuentaMas,
                //foto
            ];
        }
        
        return response()->json($arrayUsrs);

        */




        return response()->json(['usuario'=>$user->usrSistema,'email'=>$user->correo]);
    }


    public function userxemail($email){
       
        $user = Usuario::where('correo',$email)->firstOrFail();
        
        echo $user->usrSistema;
    }


    public function userslikename(Request $data){
       
        $arrayUsrs=[];
        $nombre= $data->input('nombre');
        $users =Usuario::where('usrSistema','like','%'.$nombre.'%')->get();
        

        foreach($users as $usr)
        {  
            $arrayUsrs[]=[
                'usuario'=>$usr->usrSistema
            ];
        }
        
        return response()->json($arrayUsrs);

    }

    
    public function deleteuser(Request $data){
        $idUsuario=0;
        $idSocio=0;
        $count=0;

        $idUsuario = $data->input('idUsuario');
        $idSocio= $data->input('idSocio');

        $count = Usuario::where('idUsuario',$idUsuario)->count();
        
        //Investigar la forma de tener un token por cookie
         if($data->token!='QWERTY'){
            return response()->json(['error'=>'No autorizado','exito'=>false]);
         }


         if($count<=0){
             return response()->json(['error'=>'El Usuario No Existe','exito'=>false]);
         }

         $Socio= UsuarioRelSocio::select('Socio_idSocio')->where('Usuario_idUsuario', $idUsuario)->get();

         foreach($Socio as $idS)
         {
            $idSocio =$idS->Socio_idSocio;
         }
        

        DB::beginTransaction();
        try
        {
            //Elimiar TODAS las relaciones de entidades para esete usuario
            UsuarioRelEntidad::where('Usuario_idUsuario',$idUsuario)->delete();

            if($idSocio>0)
            { 
                UsuarioRelSocio::where('Usuario_idUsuario',$idUsuario)
                               ->where('Socio_idSocio',$idSocio)->delete();
            }

            Usuario::where('idUsuario',$idUsuario)->delete();
        
            if($idSocio>0)
            { 
            Socio::where('idSocio',$idSocio)
                 ->where('idSocio','>',0)->delete();
            }


            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage(),'exito'=>false]);
        }
         
        return response()->json(['error'=>'','exito'=>true]);
    }



    public function downuser(Request $data){
        $idUsuario=0;
        $idSocio=0;
        $idUsuario = $data->input('idUsuario');
       
        $count = Usuario::where('idUsuario',$idUsuario)->count();
        
        //Investigar la forma de tener un token por cookie
         if($data->token!='QWERTY'){
            return response()->json(['error'=>'No autorizado','exito'=>false]);
         }


         if($count<=0){
             return response()->json(['error'=>'El Usuario No Existe','exito'=>false]);
         }

         $Socio= UsuarioRelSocio::select('Socio_idSocio')->where('Usuario_idUsuario', $idUsuario)->get();

         foreach($Socio as $idS)
         {
            $idSocio =$idS->Socio_idSocio;
         }

         
        DB::beginTransaction();
        try
        {
           
            //Actualizamos el estaus del usuario a inactivo 
           Usuario::where('correo', $correo)
           ->where('passwSistema',$oldPassw)->update(array('iEstatusReg' => 0));

           if($idSocio>0)
           { 
                //Actualizamos el estaus del socio a inactivo 
                Socio::where('idSocio', $idSocio)
                     ->where('correo',$correo)->update(array('statusReg' => 0));
           }

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage(),'exito'=>false]);
        }
         
        return response()->json(['error'=>'','exito'=>true]);
    }





    public function updatepassword(Request $data){
       
        $oldPassw = $data->input('oldPassw');
        $newPassw = $data->input('newPassw');
        $correo = $data->input('correo');
       
        $count = Usuario::where('correo',$correo)
                        ->where('passwSistema',$oldPassw)->count();
        
        if($count<=0){
            return response()->json(['error'=>'El usuario no existe o el password es incorrecto ','exito'=>false]);
        }
        
        DB::beginTransaction();
        try
        {
           //Actualizamos el password del  usuario
           Usuario::where('correo', $correo)
                  ->where('passwSistema',$oldPassw)->update(array('passwSistema' => $newPassw));

         DB::commit();
        } 
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage(),'exito'=>false]);
        }
        
        return response()->json(['error'=>'','exito'=>true]);
    }



    public function registeruser(Request $data){
        $idUsuario=0;
        $idSocio=0;
        $idUsrRelSocio=0;
        $count=0;
        $existeCorreo=0;
        $idClubFrecuentaMas=0;

        $idClubFrecuentaMas = $data->input('idClubFrecuentaMas');

        //Verificamos si envió el campo correo 
        if($data->input('correo')==''){
            return response()->json(['error'=>'El campo correo no puede estar vacío','exito'=>false]);
        }

        //Verificamos si se selecciono el club por default 
        if($idClubFrecuentaMas<=0){
            return response()->json(['error'=>'No se seleccionó el Club','exito'=>false]);
        }

        //Verificamos si el correo ya existe
        $existeCorreo = Usuario::where('correo',$data->input('correo'))->count();
        if($existeCorreo>0){
            return response()->json(['error'=>'Este correo ya ha sido registrado','exito'=>false]);
        }

        

        DB::beginTransaction();
        try
        {

            $idUsuario= Usuario::insertGetId([
                'usrSistema' => $data->input('usrSistema'),
                'correo' => $data->input('correo'),
                'passwSistema' => $data->input('passwSistema'),
            ]);


           
            if($idUsuario>0){

                $idSocio=Socio::insertGetId([
                    'nombre' => $data->input('nombre'),
                    'apPaterno' => $data->input('apPaterno'),
                    'apMaterno' => $data->input('apMaterno'),
                    'correo' => $data->input('correo'),
                    'capoNombre' => $data->input('capoNombre'),
                    'fechaNacimiento' => $data->input('fechaNacimiento'),
                    'sexo' => $data->input('sexo'),
                    'idClubFrecuentaMas' => $data->input('idClubFrecuentaMas'),
                ]);

                
                //Insertamos la relacion del usuario con su entidad elegida
                if( $idClubFrecuentaMas >0){
                    UsuarioRelEntidad::insertGetId([
                        'Usuario_idUsuario' => $idUsuario,
                        'Entidad_idEntidad' => $idClubFrecuentaMas
                    ]);
                }else{ 
                    throw new \Exception("No fué posible registrar relacion usr-club");
                }
                

                //Insertamos la relacion Usuario <-> Socio
                if($idSocio>0){
                    UsuarioRelSocio::insertGetId([
                        'Usuario_idUsuario' => $idUsuario,
                        'Socio_idSocio' => $idSocio
                    ]);
                }else{ 
                    throw new \Exception("No fué posible registrar socio");
                }

                //Actualizamos el socio ligado al usuario
               // Usuario::where('idUsuario', $idUsuario)->update(array('esSocio_idSocio' => $idSocio));

            }
            else{
                throw new \Exception("No fué posible registrar el usuario");
            }
           

         DB::commit();
        } 
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage(),'exito'=>false]);
        }
        


        $count = Usuario::where('idUsuario',$idUsuario)->count();
        
        if($count<=0){
            return response()->json(['error'=>'Error al registrar el usuario','exito'=>false]);
          }
        else{
            $user = Usuario::where('idUsuario',$idUsuario)->firstOrFail();
            return response()->json(['error'=>'','exito'=>true,
                                     'usuario'=>$user->usrSistema,'email'=>$user->correo]);
        }
       


    }


    
    public function login(Request $data){
     
        $count = Usuario::where('usrSistema',$data->input('usrSistema'))
                    ->where('passwSistema',$data->input('passwSistema'))
                    ->count();
        
            
          if($count<=0){
            return response()->json(['error'=>'Usuario y/o Password incorrectos','exito'=>false]);
          }
        else{
            $user = Usuario::where('usrSistema',$data->input('usrSistema'))
            ->where('passwSistema',$data->input('passwSistema'))
            ->firstOrFail();
    
             return response()->json(['exito'=>true,'error'=>'','usrSistema'=>$user->usrSistema,
                                                                'email'=>$user->correo,
                                                                'idUsuario'=>$user->idUsuario]);
        
        }
      
        
    }



    public function loginsp(Request $data){
     
        $count = Usuario::where('usrSistema',$data->input('usrSistema'))
                        ->where('passwSistema',$data->input('passwSistema'))
                        ->count();
        
            
          if($count<=0){
            return response()->json(['error'=>'Usuario y/o Password incorrectos','exito'=>false]);
          }
        else{

            //Funciona OK
            //$user =  DB::statement('call pcLogin(?,?)',[$data->input('usrSistema'),$data->input('passwSistema')]);

           $model= new Usuario();
                      
           $users = $model ->hydrate(
                DB::select('call pcLogin(?,?)',[$data->input('usrSistema'),$data->input('passwSistema')])
           );

           return $users;
           
        }
      
        
    }




    //-------------------------------------------------------------------------

    public function getUsuarioPopular($id)
    {
       return response()->json( ['nombre'=>'erick_showPopular','id'=>$id] );
    }


    
    public function index()
    {
        $age =32;
        $id2=878;
       return response()->json( ['nombre'=>'erick','id'=>$id2,'edad'=>$age] );
    }

    


/*

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
       return response()->json( ['nombre'=>'erick_2','id'=>$id] );
    }

    public function edit($id)
    {
        //
    }

    
    //Update the specified resource in storage.
    // @param  \Illuminate\Http\Request  $request
    // @param  int  $id
    // @return \Illuminate\Http\Response
     
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }

*/




}
