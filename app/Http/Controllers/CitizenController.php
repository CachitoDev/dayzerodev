<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidatedSearchRequest;
use App\Imports\CitizenImport;
use App\Jobs\ProcessCitizenImport;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ValidatedSearchRequest $request)
    {
        $search = $request->search;

        $citizens = Citizen::query()
            ->when($search, function ($query) use ($search) {
                if (is_numeric($search)) {
                    $query->where('id', $search);
                }
                return $query->orWhere('folio', 'like', $search . '%')
                    ->orWhere('name', 'like', $search . '%')
                    ->orWhere('curp', 'like', $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('citizens.index', ['citizens' => $citizens]);
    }

    /**
     *
     */
    public function verifiedCitizen(Citizen $citizen)
    {
        $citizen->update(['verified' => true]);

        return redirect()->back();
    }

    /**
     *
     */
    public function import()
    {
        return view('citizens.import');
    }

    /**
     *
     */
    public function importSave(Request $request)
    {
        $file = $request->file('import_file');
        $fileName = Str::uuid() . '--' . now()->format('y_m_d') . '.csv';
        $result = Storage::disk('s3')->put($fileName, $file->getContent());
        if (!$result) {
            return redirect()->back()->withErrors('Error al subir el archivo');
        }

        ProcessCitizenImport::dispatch($fileName);


        return redirect()->route('citizens.index')->with('success', 'Tiendas importadas exitosamente.');
    }
}
