<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'Datatable.php';

use DatatableL\DataTable;

//implement single array and multiple array;
$arr = [
    [
        'user_name' => 'Imam Hossain Reyad',
        'user_phone' => '01856228493',
        'user_email' => 'imam.reyad93@gmail.com',
    ],
    [
        'user_name' => 'ibrahim',
        'user_phone' => '01856228443',
        'user_email' => 'ibrahim@gmail.com',
    ],
    [
        'user_name' => 'Reyad',
        'user_phone' => '01856228465',
        'user_email' => 'reyad93@gmail.com',
    ],
];


$perm = 'Open';
$table = new DataTable();
if (isset($_GET['toCsv'])) {
    $table->from($arr)->toCSV();
}
$toTable = $table->from($arr)->toTable();
$toJson = $table->from($arr)->toJson();
$toXml = $table->from($arr)->toXml();

?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<div class="container">
    <?php
    echo "<pre>";
    echo "<h4>Table: </h4>";
    echo "<pre>";
    print_r($toTable);

    echo "<h4>Add Column:</h4>";
    $addCLM = $table->from($arr)
        ->addColumn('Password', function () use (&$sl1) {
            return uniqid();
        })
        ->addColumn('Action', function ($arr) use ($perm) {
            return '<button class="btn btn-success btn-xs">' . $perm . '</button>';
        })
        ->toTable();
    print_r($addCLM);


    echo "<h4>Edit Column:</h4>";
    $table_with_editColumn = $table->from($arr)
        ->editColumn('user_email', function ($data) {
            return '<b>' . $data['user_email'] . '</b>';
        })
        ->editColumn('user_name', function ($data) {
            return '<b>' . $data['user_name'] . '</b>';
        })
        ->toTable();
    print_r($table_with_editColumn);

    echo "<h4>Remove Column</h4>";
    $table_after_removeColumn = $table->from($arr)
        ->addColumn('Action', function ($arr) use ($perm) {
            return '<button class="btn btn-success btn-xs">' . $perm . '</button>';
        })
        ->removeColumn('user_name')
        ->toTable();
    print_r($table_after_removeColumn);

    echo "<h4>TO CSV</h4>";
    echo "<a href='?toCsv=csv' class='btn btn-success btn-MD'>Download To CSV</a><br>";

    echo "<h4>To Json</h4>";
    echo "<textarea rows='15' cols='50'>";
    echo $toJson;
    echo "</textarea>";

    echo "<h4>To XML</h4>";
    echo "<textarea rows='15' cols='50'>";
    echo $toXml;
    echo "</textarea>";
    ?>
</div>






