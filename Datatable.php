<?php

namespace DatatableL;
//use TableRender\TableRender;

use SimpleXMLElement;
use TableRender\TableRender;

require 'TableRender.php';

class DataTable extends TableRender
{
    protected $arrayData;


    public function toTable()
    {
        return self::tableHtml();
    }

    public function from($data)
    {
        $this->arrayData = $data;  //associative array
        return $this;

    }

    public function addColumn($col, $function)
    {
        $all_data = [];
        foreach ($this->arrayData as $row) {
            $row[$col] = call_user_func($function, $this->arrayData);
            array_push($all_data, $row);
        }
        $this->arrayData = $all_data;
        return $this;
    }

    public function editColumn($column_name, $user_function)
    {
        $all_data = [];
        foreach ($this->arrayData as $row) {
            $row[$column_name] = $user_function($row);
            array_push($all_data, $row);
        }
        $this->arrayData = $all_data;
        return $this;
    }


    public function removeColumn(...$arguments)
    {

        if (!empty($arguments)) {
            $arry    = array_combine(preg_replace('/[^a-zA-Z0-9\']/', '_', $arguments), preg_replace('/[^a-zA-Z0-9\']/', '_', $arguments));
            $rowData = [];
            foreach ($this->arrayData as $key=>$row) {
                $array = array_diff_key($row, $arry);
                array_push($rowData, $array);
            }

            $this->arrayData = $rowData;
        }
        return $this;
    }

    public function toCSV()
    {
        // output headers so that the file is downloaded rather than displayed
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="table.csv"');

// do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');

// create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');

        fputcsv($file, array_keys($this->arrayData[0]));
// output each row of the data
        foreach ($this->arrayData as $row)
        {
            fputcsv($file, $row);
        }

        exit();
    }


    public function toXml()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0"?><dataTable></dataTable>');
        foreach ($this->arrayData as $si => $val) {
            if (is_array($val)) {
                $child = $xml->addChild("row_$si");
                foreach ($val as $key => $value) {
                    $child->addChild($key, $value);
                }
            } else {
                $xml->addChild($si, $val);
            }
        }
        return $xml->saveXML();
    }

    public function toJson()
    {
        return json_encode($this->arrayData);
    }

}

