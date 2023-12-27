@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Transaksi {{ $item->user->name }}</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td>ID</td>
                        <td>{{ $item->id }}</td>
                    </tr>
                    <tr>
                        <td>Paket Travel</td>
                        <td>{{ $item->travel_package->title }}</td>
                    </tr>
                    <tr>
                        <td>Pembeli</td>
                        <td>{{ $item->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Additional Visa</td>
                        <td>{{ $item->additional_visa }}</td>
                    </tr>
                    <tr>
                        <td>Total Transaksi</td>
                        <td>{{ $item->transaction_total }}</td>
                    </tr>
                    <tr>
                        <td>Status Transaksi</td>
                        <td>{{ $item->transaction_status }}</td>
                    </tr>
                    <tr>
                        <th>Pembelian</th>
                        <td>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Nationality</th>
                                        <th>Visa</th>
                                        <th>DOE Passport</th>
                                    </tr>
                                </thead>
                                @foreach ($item->details as $detail)
                                    <tbody>
                                        <tr>
                                            <td>{{ $detail->id }}</td>
                                            <td>{{ $detail->username }}</td>
                                            <td>{{ $detail->nationality }}</td>
                                            <td>{{ $detail->is_visa ? '30 Days' : 'N/A' }}</td>
                                            <td>{{ $detail->doe_passport }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
