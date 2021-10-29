@extends('adminlte::page')

@section('title', 'Transaksi')

@section('content_header')
    <h1 class="m-0 text-dark">Transaksi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h4>Rp. 535.200.500,-</h4>
                            <p>Total Keuangan Bulan November</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#createModal">
                            Info Transaksi <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <p>Total Transaksi Masuk</p>
                            <h4>Rp. 34.231.023,-</h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-circle-down"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#transaksiMasuk">
                            Tambah Transaksi Masuk <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <p>Total Transaksi Keluar</p>
                            <h4>Rp. 34.231.023,-</h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-circle-up"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#transaksiKeluar">
                            Tambah Transaksi Keluar <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data Transaksi</h3>
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
                                            <th style="text-align:center">Tanggal</th>
                                            <th style="text-align:center">Kode</th>
                                            <th style="text-align:center">Nama Anggota</th>
                                            <th style="text-align:center">Jenis Transaksi</th>
                                            <th style="text-align:center">Validasi</th>
                                            <th style="text-align:center">Debit</th>
                                            <th style="text-align:center">Kredit</th>
                                            <th style="text-align:center">Keterangan</th>
                                            <th style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksis as $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $item->tanggal }}</td>
                                                <td>{{ $item->kode }}</td>
                                                <td>{{ $item->anggota->user->name }}</td>
                                                <td>{{ $item->jenis }}</td>
                                                <td>
                                                    @if ($item->validasi == '0')
                                                        Belum Valid
                                                    @else
                                                        Valid
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->tipe == 'Debit')
                                                        {{ $item->nominal }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->tipe == 'Kredit')
                                                        {{ $item->nominal }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td> {{ $item->keterangan }}</td>
                                                <td>
                                                    <a class="btn btn-xs btn-warning"
                                                        href="{{ route('transaksi.edit', $item) }}" data-toggle="tooltip"
                                                        title="Edit {{ $item->name }}"><i class=" fas fa-edit"></i></a>
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

    <!-- Transaksi Masuk Modal -->
    <div class="modal fade" id="transaksiMasuk" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="createModalLabel">Tambah Data Transaksi Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'transaksi.store', 'method' => 'POST', 'files' => true]) !!}
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Ada kesalahan input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="iKode">Kode Transaksi</label>
                        {!! Form::text('kode', $kodetransaksi, ['class' => 'form-control' . ($errors->has('kode') ? ' is-invalid' : ''), 'id' => 'iKode', 'readonly', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iTanggal">Tanggal</label>
                        {!! Form::date('tanggal', \Carbon\Carbon::now(), ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iAnggota">Nama Anggota</label>
                        {!! Form::select('anggota_id', $users->pluck('name', 'id'), null, ['class' => 'form-control' . ($errors->has('anggota_id') ? ' is-invalid' : ''), 'id' => 'iAnggota', 'autofocus', 'placeholder' => 'Nama Anggota', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iJenis">Jenis Transaksi</label>
                        {!! Form::select('jenis', $debittransaksi, null, ['class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''), 'id' => 'iJenis', 'placeholder' => 'Jenis Transaksi', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('validasi', '0', ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('tipe', 'Debit', ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iNominal">Nominal</label>
                        {!! Form::number('nominal', null, ['class' => 'form-control' . ($errors->has('nominal') ? ' is-invalid' : ''), 'id' => 'iNominal', 'placeholder' => 'Nominal Pemasukan', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iKeterangan">Keterangan</label>
                        {!! Form::textarea('keterangan', null, ['class' => 'form-control' . ($errors->has('keterangan') ? ' is-invalid' : ''), 'rows' => 3, 'id' => 'iKeterangan', 'placeholder' => 'Alamat', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iUser">Administrator</label>
                        {!! Form::text('user_id', Auth::user()->name, ['class' => 'form-control' . ($errors->has('user_id') ? ' is-invalid' : ''), 'id' => 'iUser', 'readonly', 'required']) !!}
                        {!! Form::hidden('user_id', Auth::user()->id, ['readonly']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!-- Transaksi Keluar Modal -->
    <div class="modal fade" id="transaksiKeluar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="createModalLabel">Tambah Data Transaksi Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'transaksi.store', 'method' => 'POST', 'files' => true]) !!}
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Ada kesalahan input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="iKode">Kode Transaksi</label>
                        {!! Form::text('kode', $kodetransaksi, ['class' => 'form-control' . ($errors->has('kode') ? ' is-invalid' : ''), 'id' => 'iKode', 'readonly', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iTanggal">Tanggal</label>
                        {!! Form::date('tanggal', \Carbon\Carbon::now(), ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iAnggota">Nama Anggota</label>
                        {!! Form::select('anggota_id', $users->pluck('name', 'id'), null, ['class' => 'form-control' . ($errors->has('anggota_id') ? ' is-invalid' : ''), 'id' => 'iAnggota', 'autofocus', 'placeholder' => 'Nama Anggota', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iJenis">Jenis Transaksi</label>
                        {!! Form::select('jenis', $kredittransaksi, null, ['class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''), 'id' => 'iJenis', 'placeholder' => 'Jenis Transaksi', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('validasi', '0', ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('tipe', 'Kredit', ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iNominal">Nominal</label>
                        {!! Form::number('nominal', null, ['class' => 'form-control' . ($errors->has('nominal') ? ' is-invalid' : ''), 'id' => 'iNominal', 'placeholder' => 'Nominal Pemasukan', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iKeterangan">Keterangan</label>
                        {!! Form::textarea('keterangan', null, ['class' => 'form-control' . ($errors->has('keterangan') ? ' is-invalid' : ''), 'rows' => 3, 'id' => 'iKeterangan', 'placeholder' => 'Alamat', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iUser">Administrator</label>
                        {!! Form::text('user_id', Auth::user()->name, ['class' => 'form-control' . ($errors->has('user_id') ? ' is-invalid' : ''), 'id' => 'iUser', 'readonly', 'required']) !!}
                        {!! Form::hidden('user_id', Auth::user()->id, ['readonly']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('js')
    {{-- <script type="text/javascript">
        @if ($errors->any())
            $('#createModal').modal('show');
        @endif
    </script> --}}

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
