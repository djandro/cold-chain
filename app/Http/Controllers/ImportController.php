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

    public function getHtmlForCsvData($csv_data){
        $html = "<table class='table'>";
        // table header
        foreach($csv_data as $row){
            $html .= "<tr>";
            foreach($row as $key => $value){
                $html .= "<td>" . $value . "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "<tr>";
        // table body
        foreach($csv_data[0] as $key => $row){
            $html .= "<td>" . "<select name='fields[" . $key  .  "]'>";
            if(!in_array($row, config('app.record_data'))) $row = '--ignore--';

            foreach(config('app.record_data') as $db_field){
                $selected = ($row == $db_field) ? 'selected' : '';
                $html .= "<option value='" . $db_field . "' " .$selected. ">" . $db_field . "</option>";
            }
            $html .= "</select>" . "</td>";
        }
        $html .= "</tr>" . "</table>";

        return $html;
    }

    public function parseImport(CsvImportRequest $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        //dump($data);

        $rows = 0; $nr_rows = 0; $colums = null;

        foreach($data as $key => $row){
            if($row[0] != '#'){
                $nr_rows = $key;
                break;
            }
        }

        $csv_data = array_slice($data, $nr_rows, 3);
        $html_data = $this->getHtmlForCsvData($csv_data);

        dump($csv_data[0]);

        return response()->json(
            array('html' => $html_data)
        );
    }
}