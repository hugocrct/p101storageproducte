@extends('master')

@section('title', 'Benvinguda')

@section('content')
    <div class="p-5 mb-4 bg-white rounded-3 shadow-sm">
        <h1 class="display-5 fw-bold">Benvingut a l'aplicatiu de productes</h1>
        <p class="fs-5 text-muted">
            Registra productes, guarda'ls en fitxers JSON i XML i consulta'ls quan vulguis.
        </p>
        <a href="{{ url('/register') }}" class="btn btn-primary btn-lg me-2">Registrar un producte</a>
        <a href="{{ url('/json') }}" class="btn btn-outline-secondary btn-lg me-2">Veure JSON</a>
        <a href="{{ url('/xml') }}" class="btn btn-outline-secondary btn-lg">Veure XML</a>
    </div>
@endsection