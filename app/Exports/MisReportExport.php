<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MisReportExport implements FromView {

    protected $pdata;
    protected $view_link;

    public function __construct(array $pdata, $view_link) {
        $this->pdata     = $pdata;
        $this->view_link = $view_link;
    }

    public function view(): view {
        return view($this->view_link,
            $this->pdata
        );
    }

}