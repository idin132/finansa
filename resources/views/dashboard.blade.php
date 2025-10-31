@extends('layouts.sidebar')
@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>Rp. {{ number_format($total_pemasukan, 0, ',', ',') }}</h3>
                            <p>Total Pemasukan</p>
                        </div>
                        <a href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
                <!--end::Col-->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>Rp. {{ number_format($total_pengeluaran, 0, ',', ',') }}</h3>
                            <p>Total Pengeluaran</p>
                        </div>
                        <a href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
                <!--end::Col-->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>Rp. {{ number_format($total_pemasukan_hari_ini, 0, ',', ',') }}</h3>
                            <p>Pemasukan Hari Ini</p>
                        </div>
                        <a href="#"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 3-->
                </div>
                <!--end::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 4-->
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>Rp. {{ number_format($total_pengeluaran_hari_ini, 0, ',', ',') }}</h3>
                            <p>Pengeluaran Hari Ini</p>
                        </div>
                        <a href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="small-box text-bg-info text-center">
                        <div class="info-box-content">
                            <h4>Uang Tersisa</h4>
                            <h4>Rp. {{ number_format($uang_tersisa, 0, ',', ',') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
                <!-- <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Monthly Recap Report</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-tool dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        <i class="bi bi-wrench"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" role="menu">
                                        <a href="#" class="dropdown-item">Action</a>
                                        <a href="#" class="dropdown-item">Another action</a>
                                        <a href="#" class="dropdown-item"> Something else here </a>
                                        <a class="dropdown-divider"></a>
                                        <a href="#" class="dropdown-item">Separated link</a>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="text-center">
                                        <strong>Sales: 1 Jan, 2023 - 30 Jul, 2023</strong>
                                    </p>
                                    <div id="sales-chart"></div>
                                </div>
                                    <p class="text-center"><strong>Goal Completion</strong></p>
                                    <div class="progress-group">
                                        Add Products to Cart
                                        <span class="float-end"><b>160</b>/200</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar text-bg-primary" style="width: 80%"></div>
                                        </div>
                                    </div>
                                    <div class="progress-group">
                                        Complete Purchase
                                        <span class="float-end"><b>310</b>/400</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar text-bg-danger" style="width: 75%"></div>
                                        </div>
                                    </div>
                                    <div class="progress-group">
                                        <span class="progress-text">Visit Premium Page</span>
                                        <span class="float-end"><b>480</b>/800</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar text-bg-success" style="width: 60%"></div>
                                        </div>
                                    </div>
                                    <div class="progress-group">
                                        Send Inquiries
                                        <span class="float-end"><b>250</b>/500</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar text-bg-warning" style="width: 50%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <div class="text-center border-end">
                                        <span class="text-success">
                                            <i class="bi bi-caret-up-fill"></i> 17%
                                        </span>
                                        <h5 class="fw-bold mb-0">$35,210.43</h5>
                                        <span class="text-uppercase">TOTAL REVENUE</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="text-center border-end">
                                        <span class="text-info"> <i class="bi bi-caret-left-fill"></i> 0% </span>
                                        <h5 class="fw-bold mb-0">$10,390.90</h5>
                                        <span class="text-uppercase">TOTAL COST</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="text-center border-end">
                                        <span class="text-success">
                                            <i class="bi bi-caret-up-fill"></i> 20%
                                        </span>
                                        <h5 class="fw-bold mb-0">$24,813.53</h5>
                                        <span class="text-uppercase">TOTAL PROFIT</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="text-center">
                                        <span class="text-danger">
                                            <i class="bi bi-caret-down-fill"></i> 18%
                                        </span>
                                        <h5 class="fw-bold mb-0">1200</h5>
                                        <span class="text-uppercase">GOAL COMPLETIONS</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="info-box mb-3 text-bg-warning">
                    <span class="info-box-icon"> <i class="bi bi-tag-fill"></i> </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Inventory</span>
                        <span class="info-box-number">5,200</span>
                    </div>
                </div>
                <div class="info-box mb-3 text-bg-success">
                    <span class="info-box-icon"> <i class="bi bi-heart-fill"></i> </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mentions</span>
                        <span class="info-box-number">92,050</span>
                    </div>
                </div>
                <div class="info-box mb-3 text-bg-danger">
                    <span class="info-box-icon"> <i class="bi bi-cloud-download"></i> </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Downloads</span>
                        <span class="info-box-number">114,381</span>
                    </div>
                </div>
                <div class="info-box mb-3 text-bg-info">
                    <span class="info-box-icon"> <i class="bi bi-chat-fill"></i> </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Direct Messages</span>
                        <span class="info-box-number">163,921</span>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <!-- Start col -->
                <!-- /.Start col -->
                <!-- Start col -->
                <!-- /.Start col -->
            </div>
        </div>
    </div>
</main>
@endsection