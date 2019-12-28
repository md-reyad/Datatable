<?php
namespace TableRender;

class TableRender
{

    protected function tableHtml()
    {
        $table_head = '<thead><tr>';

        foreach (array_keys($this->arrayData[0]) as $key => $value) {
            $table_head .= '<th>' . preg_replace('/[^a-zA-Z0-9\']/', ' ', $value) . '</th>';
        }
        $table_head .= '</tr><thead>';

        $table_body = '';
        foreach ($this->arrayData as $key => $value) {
            $table_body .= '<tr>';
            foreach ($value as $key => $value) {
                $table_body .= '<td>' . $value . '</td>';
            }
            $table_body .= '</tr>';
        }
        $table_body = '<tbody>' . $table_body . '</tbody>';
        return '<table class="table table-bordered">' . $table_head . $table_body . '</table>';

    }
}
