@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">{{ __('Registro del Producto') }}
            
                </div>

                <div class="card-body">

                    <div class="row">
                        <x-adminlte-input name="name" label="Nombre" placeholder="Ingresar el Nombre"
                            fgroup-class="col-md-6" />
                    </div>

                    <div class="row">
                        <x-adminlte-textarea name="description" label="Descripcion" placeholder="Descripcion del Producto"
                            fgroup-class="col-md-6" >
                        </x-adminlte-textarea>
                    </div>

                   {{-- <div class="row">
                    <x-adminlte-select2 name="categoria" label="Categoria" data-placeholder="Selecciona" fgroup-class="col-md-6" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-building"></i>
                        </div>
                    </x-slot>
                    <x-adminlte-options :options="['Car', 'Truck', 'Motorcycle','Gandola', 'etc']" empty-option/>
                    </x-adminlte-select2>

                    </div>
                    --}}

                    <div class="row justify-content-center">

                        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
                
                            
                
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
