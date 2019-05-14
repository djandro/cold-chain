<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use App\TemporaryData;
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

    public function getProducts($selected = null){
        // todo read from database getProducts
        return response()->json(
            array(
                1 => 'Tuna',
                2 => 'Orchards',
                3 => 'Squid',
            )
        );
    }

    public function getLocations($selected = null){
        // todo read from database getLocations
        return response()->json(
            array(
                1 => 'Cold storage',
                2 => 'LeM',
                3 => 'Transport 1',
                4 => 'Transport 2',
            )
        );
    }

    public function parseImport(CsvImportRequest $request) {
        $path = $request->file('csv_file')->getRealPath();
        $file_name = $request->file('csv_file')->getClientOriginalName();
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
                if($row[1] == 'Measurements') $samples = $row[2];
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

        // save data to temporary table
        $temp_data = TemporaryData::create([
            'data' => json_encode($data)
        ]);

        // todo get file stats - samples, start times, interval, delay

        return response()->json(
            array(
                'headers_data' => $headers_data,
                'product' => $this->getProducts(),
                'location' => $this->getLocations( $location ),
                'temporary_table_id' => $temp_data->id,
                'samples' => $samples,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'delay' => 0,
                'interval' => $interval,
                'title' => $title,
                'file_name' => $file_name,
                'comment' => $description
            )
        );
    }

    public function saveImport(Request $request){
        dump($request->all());

        return response()->json(
            $request->all()
        );
    }
}