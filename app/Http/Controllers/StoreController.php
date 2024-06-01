<?php

namespace App\Http\Controllers;

use App\Imports\StoreImport;
use App\Models\RequestLog;
use App\Models\Store;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::query()->orderBy('name', 'ASC')->paginate(50);

        return view('stores.index')->with('stores', $stores);
    }

    public function create()
    {
        return view('stores.create');
    }

    public function store(Request $request)
    {
        $log = RequestLog::store($request);
        $this->validate($request, [
            'name'      => ['required', 'string'],
            'radius'    => ['required', 'numeric'],
            'latitude'  => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'estimated' => ['nullable', 'numeric',]
        ]);

        $store = Store::create([
            'name'      => $request->name,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'radius'    => $request->radius,
            'estimated' => $request->estimated,
        ]);

        $store->generateGeometry();

        return redirect()->route('stores.index');
    }

    public function show(Store $store)
    {
        return view('stores.show')->with('store', $store);
    }

    public function update(Request $request, Store $store)
    {
        $this->validate($request, [
            'name'      => ['required', 'string'],
            'number'    => ['required', 'numeric'],
            'radius'    => ['required', 'numeric'],
            'latitude'  => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'estimated' => ['nullable', 'numeric',]
        ]);

        $store->update([
            'number'    => $request->number,
            'name'      => $request->name,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'radius'    => $request->radius,
            'estimated' => $request->estimated,
        ]);
        $store->generateGeometry();

        return redirect()->route('stores.show', $store);
    }

    public function import()
    {
        return view('stores.import');
    }

    public function importSave(Request $request)
    {
        $file = $request->file('import_file');

        Excel::import(new StoreImport, $file);

        return redirect()->route('stores.index')->with('success', 'Tiendas importadas exitosamente.');
    }
}
