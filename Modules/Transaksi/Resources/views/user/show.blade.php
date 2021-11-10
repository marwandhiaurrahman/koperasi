@extends('adminlte::page')

@section('title', 'Detail Transaksi ')

@section('content_header')
    <h1 class="m-0 text-dark">Detail Transaksi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Detail Transaksi</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                {!! Form::model($transaksi, ['method' => 'PATCH', 'route' => ['admin.transaksi.update', $transaksi], 'files' => true]) !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="iKode">Kode Transaksi</label>
                        {!! Form::text('kode', null, ['class' => 'form-control' . ($errors->has('kode') ? ' is-invalid' : ''), 'id' => 'iKode', 'readonly', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iTanggal">Tanggal</label>
                        {!! Form::date('tanggal', \Carbon\Carbon::now(), ['class' => 'form-control', 'required', 'readonly']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iAnggota">Nama Anggota</label>
                        {!! Form::text('anggota_id', $transaksi->anggota->name, ['class' => 'form-control' . ($errors->has('anggota_id') ? ' is-invalid' : ''), 'id' => 'iUser', 'readonly', 'required']) !!}
                        {!! Form::hidden('anggota_id', $transaksi->anggota->id, ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iJenis">Jenis Transaksi</label>
                        {!! Form::select('jenis', $debittransaksi, null, ['class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''), 'id' => 'iJenis', 'readonly', 'disabled', 'placeholder' => 'Jenis Transaksi', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('validasi', '0', ['readonly']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iNominal">Nominal</label>
                        {!! Form::number('nominal', abs($transaksi->nominal), ['class' => 'form-control' . ($errors->has('nominal') ? ' is-invalid' : ''), 'readonly', 'id' => 'iNominal', 'placeholder' => 'Nominal Pemasukan', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iNominal">Nominal</label>

                        {!! Form::text('tipe', 'Debit', ['class' => 'form-control' . ($errors->has('nominal') ? ' is-invalid' : ''), 'readonly']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iKeterangan">Keterangan</label>
                        {!! Form::textarea('keterangan', null, ['class' => 'form-control' . ($errors->has('keterangan') ? ' is-invalid' : ''), 'rows' => 3, 'readonly', 'id' => 'iKeterangan', 'placeholder' => 'Keterangan', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iUser">Checkers</label>
                        {!! Form::text('user_id', $transaksi->user_id ? App\Models\User::find($transaksi->user_id)->name : 'Belum Validasi', ['class' => 'form-control' . ($errors->has('user_id') ? ' is-invalid' : ''), 'id' => 'iUser', 'readonly', 'required']) !!}
                        {!! Form::hidden('user_id', $transaksi->user_id, ['readonly']) !!}
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input name="validasi" class="custom-control-input" type="checkbox" id="customCheckbox1" value="1"
                            {{ $transaksi->validasi == '1' ? 'checked' : '' }} disabled>
                        <label for="customCheckbox1" class="custom-control-label">Validasi Transaksi
                            {{ $transaksi->validasi }}</label>
                    </div>
                </div>
                <!-- /.card-body -->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Toggle --}}
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('js')
    {{-- Toggle Button --}}
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection
