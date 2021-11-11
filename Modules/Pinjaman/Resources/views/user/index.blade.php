@extends('adminlte::page')

@section('title', 'Pinjaman ' . $user->name)

@section('content_header')
    <h1 class="m-0 text-dark">Pinjaman {{ $user->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h4>
                                {{ money($saldopinjaman, 'IDR') }},-
                            </h4>
                            <p>Saldo Transaksi Pinjaman</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#pinjamanTambah">
                            Mengajukan Pinjaman <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h4>{{ money($saldopinjaman, 'IDR') }}</h4>
                            <p>Total Angsuran Peminjaman</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#angsuranBayar">
                            Bayar Angsuran Pinjaman <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">{{ money($totalpinjaman, 'IDR') }},-</span>
                            <span class="info-box-text">Total Pinjaman</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-copy"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">{{ money(0, 'IDR') }}</span>
                            <span class="info-box-text">Angsuran Pinjaman</span>
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
                                            <th style="text-align:center">Plafon</th>
                                            <th style="text-align:center">Jasa</th>
                                            <th style="text-align:center">Saldo Pinjaman</th>
                                            <th style="text-align:center">Jatuh Tempo</th>
                                            <th style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pinjamans as $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $item->kode }}</td>
                                                <td>{{ $item->anggota->name }}</td>
                                                <td>{{ $item->jenis }} <br> {{ $item->waktu }} bulan</td>
                                                <td>{{ $item->angsuranke }}</td>
                                                <td>{{ money($item->plafon, 'IDR') }}</td>
                                                <td>{{ money($item->jasa, 'IDR') }}</td>
                                                <td>{{ money($item->saldo, 'IDR') }}</td>
                                                <td>{{ Carbon\Carbon::parse($item->tanggal)->addMonths($item->waktu)->format('d F Y') }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-xs btn-warning"
                                                        href="{{ route('admin.pinjaman.show', $item) }}"
                                                        data-toggle="tooltip" title="Edit {{ $item->name }}"><i
                                                            class=" fas fa-eye"></i></a>
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
    <div class="modal fade" id="pinjamanTambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="createModalLabel">Tambah Pengajuan Pinjaman Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'admin.pinjaman.store', 'method' => 'POST', 'files' => true]) !!}
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
                        {!! Form::select('jenis', ['Bebas' => 'Bebas', 'Sebarkan' => 'Sebarkan'], null, ['class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''), 'id' => 'iJenis', 'placeholder' => 'Jenis Pinjaman', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('validasi', '0', ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('tipe', 'Debit', ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iPlafon">Plafon</label>
                        {!! Form::number('plafon', null, ['class' => 'form-control' . ($errors->has('plafon') ? ' is-invalid' : ''), 'id' => 'iPlafon', 'placeholder' => 'Nominal Plafon', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iWaktu">Waktu Pinjaman</label>
                        {!! Form::number('waktu', null, ['class' => 'form-control' . ($errors->has('waktu') ? ' is-invalid' : ''), 'id' => 'iWaktu', 'placeholder' => 'Tempo Pinjaman Per Bulan', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iJasa">Jasa</label>
                        {!! Form::number('jasa', null, ['class' => 'form-control' . ($errors->has('jasa') ? ' is-invalid' : ''), 'id' => 'iJasa', 'placeholder' => 'Nominal Jasa', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iKeterangan">Keterangan</label>
                        {!! Form::textarea('keterangan', null, ['class' => 'form-control' . ($errors->has('keterangan') ? ' is-invalid' : ''), 'rows' => 3, 'id' => 'iKeterangan', 'placeholder' => 'Keterangan', 'required']) !!}
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
    <!-- Transaksi Masuk Modal -->
    <div class="modal fade" id="angsuranBayar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="createModalLabel">Bayar Transaksi Pinjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'admin.transaksi.store', 'method' => 'POST', 'files' => true]) !!}
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
                        {!! Form::text('anggota_id', $user->name, ['class' => 'form-control' . ($errors->has('anggota_id') ? ' is-invalid' : ''), 'id' => 'iAnggota', 'readonly', 'required']) !!}
                        {!! Form::hidden('anggota_id', $user->id, ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iJenis">Jenis Transaksi</label>
                        {!! Form::text('jenis', 'Angsuran', ['class' => 'form-control' . ($errors->has('jenis') ? ' is-invalid' : ''), 'id' => 'iJenis', 'readonly', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('validasi', '0', ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('tipe', 'Debit', ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iPinjaman">Kode Pinjaman</label>
                        <select class="form-control">
                            @foreach ($pinjamans as $item)
                                <option value="{{$item->kode}}">{{ $item->kode }} Saldo {{ money($item->saldo, 'IDR') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="iNominal">Nominal</label>
                        {!! Form::number('nominal', null, ['class' => 'form-control' . ($errors->has('nominal') ? ' is-invalid' : ''), 'id' => 'iNominal', 'placeholder' => 'Nominal Pembayaran Angsuran', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iKeterangan">Keterangan</label>
                        {!! Form::textarea('keterangan', null, ['class' => 'form-control' . ($errors->has('keterangan') ? ' is-invalid' : ''), 'rows' => 3, 'id' => 'iKeterangan', 'placeholder' => 'Keterangan', 'required']) !!}
                    </div>
                    {{-- <div class="form-group">
                        <label for="iUser">Administrator</label>
                        {!! Form::text('user_id', Auth::user()->name, ['class' => 'form-control' . ($errors->has('user_id') ? ' is-invalid' : ''), 'id' => 'iUser', 'readonly', 'required']) !!}
                        {!! Form::hidden('user_id', Auth::user()->id, ['readonly']) !!}
                    </div> --}}
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
