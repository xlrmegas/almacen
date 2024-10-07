<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;



use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;


use Carbon\Carbon;
use Alert;
use PDF;
use DataTables;
use Auth;
use Image;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();             
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $area = Area::orderBy('name', 'ASC')->pluck('name', 'id');
        $role = Role::orderBy('name', 'ASC')->pluck('name', 'id');       
        return view('users.create', compact('role','area'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {
        DB::beginTransaction();
        
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);     
        $data['is_active'] = true;
        
        try {

            if(isset($data['image']) && ($data['image'] != null)) {
                $img = Image::make($data['image'])->resize(300, 200);
                $data['image'] = Storage::disk('s3')->put('users-profiles', $data['image']);
                              
                
            }

            $user = User::create($data);
        
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error('Error', $e->getMessage())->showConfirmButton();
            return redirect()->back()->withInput();
        }

        DB::commit();
        
        alert()->success('Registro Exitoso','El registro se ha procesado de manera exitosa')->showConfirmButton();

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {   
        //verificar usuario autorizado
        User::checkUser($user->id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        
        //verificar usuario autorizado
        User::checkUser($user->id);
        
        $area = Area::orderBy('name', 'ASC')->pluck('name', 'id');
        $role = Role::orderBy('name', 'ASC')->pluck('name', 'id'); 
        return view('users.edit', compact('user', 'area', 'role')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request, User $user)
    {
        $data = $request->all();
        
        //verificar usuario autorizado
        User::checkUser($user->id);
    
        DB::beginTransaction();
        
        
        try {

            if(isset($data['image']) && ($data['image'] != null)) {                
                Storage::disk('s3')->delete('users-profiles/' . $user->image) && Image::make($data)->resize(300, 200);                 
                $data['image'] = Storage::disk('s3')->put('users-profiles', $data['image']);
                
            }
            if(isset($data['password'])){
             $data['password'] = bcrypt($data['password']);
            }else{
            $data['password'] = $user->password;
            }
            
           // dd($data);
            $user->fill($data);
            $user->save();
            
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error('Error', $e->getMessage());
            return redirect()->back()->withInput();
        }

        DB::commit();

        alert()->success('Registro Exitoso','El registro se ha procesado de manera exitosa')->showConfirmButton();
    if(Auth::User()->role_id == 1){
        return redirect()->route('users.index');
    }else{
        return redirect()->route('home');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
       
            $user->delete();
        } catch (Exception $user) {
            alert()->error('Error', $user->getMessage())->showCloseButton()->showConfirmButton();
            return redirect()->back();
        }
        return redirect()->route('users.index');
    }

}
