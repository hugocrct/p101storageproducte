<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use SimpleXMLElement;

class ProducteController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function registerGet()
    {
        return view('register');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'descripcio' => ['required', 'string', 'max:1000'],
            'preu' => ['required', 'numeric', 'min:0'],
            'iva' => ['required', 'numeric', 'between:0,100'],
            'color' => ['required', 'string', 'max:50'],
            'talla' => ['required', 'string', 'max:20'],
        ], [
            'required' => 'El camp :attribute és obligatori.',
            'numeric' => 'El camp :attribute ha de ser un número.',
            'min' => 'El camp :attribute no pot ser negatiu.',
            'between' => 'El camp :attribute ha d\'estar entre :min i :max.',
            'max' => 'El camp :attribute no pot superar :max caràcters.',
        ]);
    }

    private function store(array $dades): void
    {
        $dades['preu_venda'] = round($dades['preu'] * (1 + $dades['iva'] / 100), 2);

        // JSON
        $productes = $this->llegirProductes();
        $productes[] = $dades;

        Storage::put(
            'productes.json',
            json_encode($productes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // XML
        if (Storage::exists('productes.xml')) {
            $xml = new SimpleXMLElement(Storage::get('productes.xml'));
        } else {
            $xml = new SimpleXMLElement('<productes/>');
        }

        $node = $xml->addChild('producte');
        foreach ($dades as $clau => $valor) {
            $node->addChild($clau, htmlspecialchars((string) $valor));
        }

        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;

        Storage::disk('public')->put('productes.xml', $dom->saveXML());
    }

    public function registerPost(Request $request)
    {
        $dades = $this->validar($request);
        $this->store($dades);

        return redirect('/register')-> with('success', 'Producte guardat correctament.');
    }

    private function llegirProductes(): array
    {
        if (!Storage::exists('productes.json')) {
            return [];
        }

        $productes = json_decode(Storage::get('productes.json'), true);

        if ($productes === null) {
            return [];
        }

        return $productes;
    }

    public function json()
    {
        $productes = $this->llegirProductes();

        return view('json', [
            'productes' => $productes,
            'contingut' => json_encode($productes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        ]);
    }

    public function xml()
    {
        $productes = [];
        $contingut = '';

        if (Storage::exists('productes.xml')) {
            $contingut = Storage::get('productes.xml');
            $xml = simplexml_load_string($contingut);

            foreach ($xml->producte as $producte) {
                $item = [];
                foreach ($producte as $clau => $valor) {
                    $item[$clau] = (string) $valor;
                }
                $productes[] = $item;
            }
        }

        return view('xml', [
            'productes' => $productes,
            'contingut' => $contingut,
        ]);
    }
}