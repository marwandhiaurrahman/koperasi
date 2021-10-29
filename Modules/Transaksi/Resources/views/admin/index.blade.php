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
                        <a href="#" class="small-box-footer">
                            Tambah Transaksi Keluar <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
                {{-- <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">Rp. 150.000.000,-</span>
                            <span class="info-box-text">Simpanan Masuk</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-copy"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">Rp. 554.000.000,-</span>
                            <span class="info-box-text">Simpanan Keluar</span>
                        </div>
                    </div>
                </div> --}}
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
                                            <th style="text-align:center">Debit</th>
                                            <th style="text-align:center">Kredit</th>
                                            <th style="text-align:center">Keterangan</th>
                                            <th style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>21/12/2021</td>
                                                <td>P00.21.12.2021</td>
                                                <td>{{ $item->name }}</td>
                                                <td>Bebas</td>
                                                <td>3</td>
                                                <td>Rp. 150.000,-</td>
                                                <td>13 Oktober 2021</td>
                                                <td>
                                                    <a class="btn btn-xs btn-warning"
                                                        href="{{ route('user.edit', $item) }}" data-toggle="tooltip"
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

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="createModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'user.store', 'method' => 'POST', 'files' => true]) !!}
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
                        <label for="inputName">Nama</label>
                        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'id' => 'inputName', 'placeholder' => 'Nama', 'autofocus', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="inputAlamat">Alamat</label>
                        {!! Form::textarea('alamat', null, ['class' => 'form-control' . ($errors->has('alamat') ? ' is-invalid' : ''), 'rows' => 3, 'id' => 'inputAlamat', 'placeholder' => 'Alamat', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="inputRoles">Role / Jabatan</label>
                        {!! Form::select('role', $roles, null, ['class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''), 'id' => 'inputRoles', 'placeholder' => 'Pilih Role / Jabatan', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">Nomor Telephone</label>
                        {!! Form::text('phone', null, ['class' => 'form-control' . ($errors->has('phone') ? ' is-invalid' : ''), 'id' => 'inputPhone', 'placeholder' => 'Nomor Telephone', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        {!! Form::email('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'id' => 'inputEmail', 'placeholder' => 'Email', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="inputUsername">Username</label>
                        {!! Form::text('username', null, ['class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''), 'id' => 'inputUsername', 'placeholder' => 'Username', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'id' => 'inputPassword', 'placeholder' => 'Password', 'required']) !!}
                    </div>

                    {{-- <div class="form-group">
                        <label for="inputPhoto">Gambar User</label>
                        <div class="input-group col-sm-10 col-md-6 col-lg-4">
                            <div class="custom-file">
                                {!! Form::file('image', ['class' >= 'custom-file-input', 'id' => 'exampleInputFile', 'required']) !!}
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group">
                        <label for="checkbox1">Status Publish</label><br>
                        <input name="status" type="checkbox" id="checkbox1" value="false" checked hidden>
                        <input name="status" type="checkbox" id="checkbox1" value="true" data-size="small"
                            data-toggle="toggle">
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
                {!! Form::open(['route' => 'user.store', 'method' => 'POST', 'files' => true]) !!}
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
                        {!! Form::text('kode', Auth::user()->name, ['class' => 'form-control' . ($errors->has('kode') ? ' is-invalid' : ''), 'id' => 'iKode', 'readonly', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iKode">Tanggal</label>
                        {!! Form::date('tanggal', \Carbon\Carbon::now(), ['class' => 'form-control','required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iUser">Nama Anggota</label>
                        {!! Form::select('user', $users->pluck('name', 'id'), null, ['class' => 'form-control' . ($errors->has('user') ? ' is-invalid' : ''), 'id' => 'iUser', 'autofocus', 'placeholder' => 'Nama Anggota', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="iJenis">Jenis Transaksi</label>
                        {!! Form::select('jenis', ['Simpanan Pokok', 'Simpanan Wajib', 'Simpanan Mana Suka', 'Angsuran', 'Jasa', 'Lainnya'], null, ['class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''), 'id' => 'iJenis', 'placeholder' => 'Jenis Transaksi', 'required']) !!}
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
                        <label for="iChecker">Checker</label>
                        {!! Form::text('checker', Auth::user()->name, ['class' => 'form-control' . ($errors->has('kode') ? ' is-invalid' : ''), 'id' => 'iChecker', 'readonly', 'required']) !!}
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
