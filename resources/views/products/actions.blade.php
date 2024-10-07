<a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Editar</a>
<form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">   

    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Eliminar</button>   

</form>