@extends('adminlte::page')

@section('title', 'Simpanan')

@section('content_header')
    <h1 class="m-0 text-dark">Simpanan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h4>
                                {{ money($transaksis->whereIn('jenis', ['Simpanan Wajib', 'Simpanan Pokok', 'Simpanan Mana Suka'])->sum('nominal'), 'IDR') }},-
                            </h4>
                            <p>Total Simpanan {{ $time->monthName }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#createModal">
                            Info Transaksi Simpanan <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h4>5 Transaksi Hari Ini</h4>
                            <p>Total Rp. 4.530.000</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Info Transaksi Simpanan <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div> --}}
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">
                                {{ money(
    $transaksis->where('tipe', 'Debit')->whereIn('jenis', ['Simpanan Wajib', 'Simpanan Pokok', 'Simpanan Mana Suka'])->sum('nominal'),
    'IDR',
) }},-
                            </span>
                            <span class="info-box-text">Simpanan Masuk</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-copy"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">
                                {{ money(
    abs(
        $transaksis->where('tipe', 'Kredit')->whereIn('jenis', ['Simpanan Wajib', 'Simpanan Pokok', 'Simpanan Mana Suka'])->sum('nominal'),
    ),
    'IDR',
) }},-
                            </span>
                            <span class="info-box-text">Simpanan Keluar</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data Simpanan</h3>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline center"
                                    role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align:center">No.</th>
                                            <th rowspan="2" style="text-align:center">Nama Anggota</th>
                                            <th colspan="3" style="text-align:center">Simpanan</th>
                                            <th rowspan="2" style="text-align:center">Total Simpanan</th>
                                            <th rowspan="2" style="text-align:center">Action</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align:center">Pokok</th>
                                            <th style="text-align:center">Wajib</th>
                                            <th style="text-align:center">Mana Suka</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td style="text-align:right">
                                                    {{ money($item->transaksis->where('jenis', 'Simpanan Pokok')->sum('nominal'), 'IDR') }}
                                                </td>
                                                <td style="text-align:right">
                                                    {{ money($item->transaksis->where('jenis', 'Simpanan Wajib')->sum('nominal'), 'IDR') }}
                                                </td>
                                                <td style="text-align:right">
                                                    {{ money($item->transaksis->where('jenis', 'Simpanan Mana Suka')->sum('nominal'), 'IDR') }}
                                                </td>
                                                <td style="text-align:right">
                                                    {{ money($item->transaksis->whereIn('jenis', ['Simpanan Mana Suka', 'Simpanan Pokok', 'Simpanan Wajib'])->sum('nominal'), 'IDR') }}
                                                </td>
                                                <td>Cek</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Total</th>
                                            <th style="text-align:right">
                                                {{ money($transaksis->where('jenis', 'Simpanan Pokok')->sum('nominal'), 'IDR') }}
                                            </th>
                                            <th style="text-align:right">
                                                {{ money($transaksis->where('jenis', 'Simpanan Wajib')->sum('nominal'), 'IDR') }}
                                            </th>
                                            <th style="text-align:right">
                                                {{ money($transaksis->where('jenis', 'Simpanan Mana Suka')->sum('nominal'), 'IDR') }}
                                            </th>
                                            <th style="text-align:right">
                                                {{ money($transaksis->whereIn('jenis', ['Simpanan Wajib', 'Simpanan Pokok', 'Simpanan Mana Suka'])->sum('nominal'), 'IDR') }}
                                            </th>
                                            <td></td>
                                        </tr>
                                    </tfoot>
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
