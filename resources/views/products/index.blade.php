@extends('layouts.app')

@section('content')
<table id="products-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
      @php
        dd($products);  
      @endphp
        @foreach($products as $product)  
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>
                    @include('products.actions', ['id' => $product->id])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@push('scripts')
@endpush
@endsection