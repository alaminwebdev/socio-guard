<style>
    .table thead {
        /* background: #0b253a !important; */
    }

    .table thead tr th {
        /* color: #f8f9fa !important; */
        border-bottom-width: 1px;
        font-size: 12px;
    }

    #indicator-loader-container{
        display: none;
        transition: all .2s linear;
    }

    #indicator-loader {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        display: block;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div class="mt-3 pt-3 border-top">

    <div id="indicator-loader-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="progress w-100 mr-3">
                <div id="indicator-progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div id="indicator-loader"></div>
        </div>
    </div>

    <div id="excel-button-container" class="mb-3 float-right" style="display: none;">
        <button type="button" id="generateExcelBtn" class="btn btn-sm btn-info" >
            <span id="button-text"><i class="fa fa-file-excel-o mr-1"></i>Excel</span>
        </button>
    </div>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center align-middle" rowspan="2" width="5%">SN.</th>
                <th class="text-center align-middle" rowspan="2" width="10%">Indicator</th>
                <th class="text-center align-middle" rowspan="2" width="20%">Indicator Statement</th>
                <th class="text-center align-middle" rowspan="2" width="5%">Year</th>
                <th class="text-center align-middle" rowspan="2" width="10%">Date</th>
                <th class="text-center align-middle" colspan="2" width="20%">Achieved</th>
                <th class="text-center align-middle" colspan="6" width="30%">Disaggregated data</th>
            </tr>
            <tr>
                <th class="text-center align-middle">TN</th>
                <th class="text-center align-middle">% in outcome</th>
                <th class="text-center align-middle">Men</th>
                <th class="text-center align-middle">Women</th>
                <th class="text-center align-middle">Other Gender</th>
                <th class="text-center align-middle">PWD Men</th>
                <th class="text-center align-middle">PWD Women</th>
                <th class="text-center align-middle">PWD Other Gender</th>
            </tr>
        </thead>

        <tbody id="table-body">

        </tbody>
    </table>

</div>
