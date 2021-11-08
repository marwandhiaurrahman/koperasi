@extends('adminlte::page')

@section('title', 'Pinjaman')

@section('content_header')
    <h1 class="m-0 text-dark">Pinjaman</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h4>Rp. 535.200.500,-</h4>
                            <p>Total Transaksi Pinjaman</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#createModal">
                            Info Transaksi Pinjaman <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h4>5 Transaksi Hari Ini</h4>
                            <p>Total Rp. 4.530.000</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Info Transaksi Pinjaman <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">Rp. 150.000.000,-</span>
                            <span class="info-box-text">Pinjaman Masuk</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-copy"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">Rp. 554.000.000,-</span>
                            <span class="info-box-text">Pinjaman Keluar</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data User</h3>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline center"
                                    role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">No.</th>
                                            <th style="text-align:center">Kode Registrasi</th>
                                            <th style="text-align:center">Nama Anggota</th>
                                            <th style="text-align:center">Jenis</th>
                                            <th style="text-align:center">Angsuran Ke</th>
                                            <th style="text-align:center">Sisa Pinjaman</th>
                                            <th style="text-align:center">Jatuh Tempo</th>
                                            <th style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>P00.21.12.2021</td>
                                                <td>{{ $item->name }}</td>
                                                <td>Bebas</td>
                                                <td>3</td>
                                                <td>Rp. 150.000,-</td>
                                                <td>13 Oktober 2021</td>
                                                <td>
                                                    <a class="btn btn-xs btn-warning"
                                                        href="{{ route('admin.pinjaman.show', $item) }}" data-toggle="tooltip"
                                                        title="Edit {{ $item->name }}"><i class=" fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('js')
    <script type="text/javascript">
        @if ($errors->any())
            $('#createModal').modal('show');
        @endif
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel", "pdf", "print", "colvis"],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
