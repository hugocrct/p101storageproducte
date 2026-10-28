@extends('master')

@section('title', 'Registrar producte')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2 class="h4 mb-0">Registrar producte</h2>
        </div>
        <div class="card-body">
            <form action="{{ url('/register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror"
                        id="nom" name="nom" value="{{ old('nom') }}" required>
                    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="descripcio" class="form-label">Descripció</label>
                    <textarea class="form-control @error('descripcio') is-invalid @enderror"
                            id="descripcio" name="descripcio" rows="3" required>{{ old('descripcio') }}</textarea>
                    @error('descripcio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="preu" class="form-label">Preu (sense IVA)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0"
                                class="form-control @error('preu') is-invalid @enderror"
                                id="preu" name="preu" value="{{ old('preu') }}" required>
                            <span class="input-group-text">€</span>
                            @error('preu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="iva" class="form-label">% IVA</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" max="100"
                                class="form-control @error('iva') is-invalid @enderror"
                                id="iva" name="iva" value="{{ old('iva', 21) }}" required>
                            <span class="input-group-text">%</span>
                            @error('iva') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control @error('color') is-invalid @enderror"
                            id="color" name="color" value="{{ old('color') }}" required>
                        @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="talla" class="form-label">Talla</label>
                        <input type="text" class="form-control @error('talla') is-invalid @enderror"
                            id="talla" name="talla" value="{{ old('talla') }}" required>
                        @error('talla') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar producte</button>
            </form>
        </div>
    </div>
@endsection