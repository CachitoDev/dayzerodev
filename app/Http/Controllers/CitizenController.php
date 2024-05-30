<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidatedSearchRequest;
use App\Imports\CitizenImport;
use App\Models\Citizen;
use Illuminate\Http\Request;
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

        Excel::import(new CitizenImport, $file);

        return redirect()->route('citizens.index')->with('success', 'Tiendas importadas exitosamente.');
    }
}
