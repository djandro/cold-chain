<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function getImport()
    {
        return view('import');
    }

    public function parseImport(CsvImportRequest $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        dump($data);

        $rows = 0; $nr_rows = 0; $colums = null;

        foreach($data as $key => $row){
            if($row[0] != '#'){
                $nr_rows = $key;
                break;
            }
        }

        $csv_data = array_slice($data, $nr_rows, 3);

        //return view('import_fields', compact('csv_data'));
        return response()->json(
            compact('csv_data')
        );
    }
}