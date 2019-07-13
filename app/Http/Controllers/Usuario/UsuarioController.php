<?php

namespace App\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{

  
    public function getUsuarioXId($id){
       
        $user = Usuario::where('idUsuario',$id)->firstOrFail();
        
        //echo $user->usrSistema;
        return response()->json(['usuario'=>$user->usrSistema,'email'=>$user->correo]);
    }


    public function getUsuarioXCorreo($email){
       
        $user = Usuario::where('correo',$email)->firstOrFail();
        
        echo $user->usrSistema;
    }


    public function getUsuariosLikeNombre($nombre){
       
        $users = Usuario::where('usrSistema','like','%'+$nombre+'%')->firstOrFail();
        
        echo $users;
    }


    public function registerUsuario(Request $data){
        $id=0;

        //return $data->input('usrSistema');
        
        
       // DB::transaction(function(){

            $id= Usuario::insertGetId([
                'usrSistema' => $data->input('usrSistema'),
                'correo' => $data->input('correo'),
                'passwSistema' => $data->input('passwSistema'),
            ]);

       // });

       // 'passwSistema' => Hash::make($data->input('passwSistema') ),

        $user = Usuario::where('idUsuario',$id)->firstOrFail();
        
        return response()->json(['usuario'=>$user->usrSistema,'email'=>$user->correo]);
        
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
    
             return response()->json(['exito'=>true,'error'=>'','usrSistema'=>$user->usrSistema,'email'=>$user->correo,'idUsuario'=>$user->idUsuario]);
        
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

            $user =  DB::statement('call pcLogin(?,?)',[$data->input('usrSistema'),$data->input('passwSistema')]);

                //pendiente
           //return $user.tostr;
           
          // return Usuario::hydrate($user);
           
            // return response()->json(['exito'=>true,'error'=>'','usrSistema'=>$user->usrSistema,'email'=>$user->correo,'idUsuario'=>$user->idUsuario]);
        

           // $users = DB::select('select * from users where active = ?', [1]);
           // return view('user.index', ['users' => $users]);


            //o asi
            /*
            $p0 = Carbon::now();
            $p1 = Carbon::now()->addDays(7);
            $p2 = 100;
            $p3 = 2;
            DB::select(DB::raw("CALL rentalsAvailables_get($p0, $p1, $p2, $p3)"));
                        
            */



        }
      
        
    }




    //-------------------------------------------------------------------------

    public function getUsuarioPopular($id)
    {
       return response()->json( ['nombre'=>'erick_showPopular','id'=>$id] );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $age =32;
        $id2=878;
       return response()->json( ['nombre'=>'erick','id'=>$id2,'edad'=>$age] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return response()->json( ['nombre'=>'erick_2','id'=>$id] );
    }


   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}