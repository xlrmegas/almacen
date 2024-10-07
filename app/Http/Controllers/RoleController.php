<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Alert;
use PDF;
use DataTables;
use Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::all();
        return view('roles.index', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all();
        return view('roles.create',compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $data = $request->all();          
                
        try {

        Role::create($data);
       
        } catch (\Exception $e) {
        
            DB::rollBack();
            alert()->error('Error', $e->getMessage())->showConfirmButton();
            return redirect()->back()->withInput();
        }

        DB::commit();
        
        alert()->success('Registro Exitoso','El registro se ha procesado de manera exitosa')->showConfirmButton();

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->all();
    
        DB::beginTransaction();
        
        try {            
            $role->fill($data);
            $role->save();
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error('Error', $e->getMessage());
            return redirect()->back()->withInput();
        }

        DB::commit();

        alert()->success('Registro Exitoso','El registro se ha procesado de manera exitosa')->showConfirmButton();

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
       
            $role->delete();
        } catch (Exception $role) {
            alert()->error('Error', $role->getMessage())->showCloseButton()->showConfirmButton();
            return redirect()->back();
        }
        return redirect()->route('roles.index');
    }
}
