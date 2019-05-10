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

    public function getHtmlForCsvHeaderData($csv_data){
        $html = "<table class='table' id='csvDataTable'>";
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
            $html .= "<td>" . "<select name='fields[" . $key  .  "]' class='form-control'>";
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

    public function parseImport(CsvImportRequest $request) {
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        //dump($data);

        $nr_rows = 0; $title = ''; $description = ''; $location = '';
        $start_date = ''; $end_date = ''; $interval = 0; $samples = 0;

        // parse headers data
        foreach($data as $key => $row){
            if(array_key_exists(1, $row)){
                if($row[1] == 'Title') $title = $row[2];
                if($row[1] == 'Description') $description = $row[2];
                if($row[1] == 'Location') $location = $row[2];
                if($row[1] == 'StartDate') $start_date = $row[2] . ', ' . $row[3];
                if($row[1] == 'EndDate') $end_date = $row[2] . ', ' . $row[3];
                if($row[1] == 'LogInterval(s)') $interval = $row[2];
                if($row[1] == 'Measurements"') $samples = $row[2];
            }
            if($row[0] != '#'){
                $nr_rows = $key;
                break;
            }
        }

        // headers data
        $csv_data = array_slice($data, $nr_rows, 3);
        $headers_data = $this->getHtmlForCsvHeaderData($csv_data);

        //dump($csv_data[0]);

        // todo get product and location

        // todo save data to temporary table

        // todo get file stats - samples, start times, interval, delay

        return response()->json(
            array(
                'headers_data' => $headers_data,
                'product' => 'Fish', // todo put select element
                'location' => $location, // todo put select element
                'temporary_table_id' => null,
                'samples' => $samples,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'delay' => 0,
                'interval' => $interval,
                'title' => $title,
                'comment' => $description
            )
        );
    }

    public function saveImport(Request $request){

    }
}