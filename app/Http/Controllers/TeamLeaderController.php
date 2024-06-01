<?php

namespace App\Http\Controllers;

use App\Models\TeamLeader;
use Illuminate\Http\Request;
use phpseclib3\Crypt\Hash;

class TeamLeaderController extends Controller
{
    public function index(Request $request)
    {
        return view('citizens.leaders-index')->with('leaders', \App\Models\TeamLeader::query()->paginate(100));
    }

    public function showImport(Request $request)
    {
        return view('citizens.leaders-import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $file = $request->file('file');
        $content = $file->getContent();
        $rows = explode("\n", $content);
        $data = [];
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }
            $row = trim($row);
            if (empty($row)) {
                continue;
            }
            $columns = explode(",", $row);
            $data[] = ['name' => $columns[0], 'phone' => $columns[1] ?? null];
        }
        TeamLeader::query()->insert($data);

        return redirect()->route('leaders.index');
    }
}
