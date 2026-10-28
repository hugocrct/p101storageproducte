@extends('master')

@section('title', 'Productes (JSON)')

@section('content')
    <h2 class="h4 mb-3">Productes guardats en JSON</h2>

    @if (empty($productes))
        <div class="alert alert-info">Encara no hi ha cap producte guardat al fitxer JSON.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle bg-white shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Descripció</th>
                        <th class="text-end">Preu (sense IVA)</th>
                        <th class="text-end">% IVA</th>
                        <th class="text-end">Preu de venda</th>
                        <th>Color</th>
                        <th>Talla</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productes as $p)
                        <tr>
                            <td>{{ $p['nom'] }}</td>
                            <td>{{ $p['descripcio'] }}</td>
                            <td class="text-end">{{ number_format($p['preu'], 2, ',', '.') }} €</td>
                            <td class="text-end">{{ $p['iva'] }} %</td>
                            <td class="text-end fw-bold">{{ number_format($p['preu_venda'], 2, ',', '.') }} €</td>
                            <td>{{ $p['color'] }}</td>
                            <td>{{ $p['talla'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection