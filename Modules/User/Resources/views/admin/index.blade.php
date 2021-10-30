@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1 class="m-0 text-dark">User / Pengguna</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ App\Models\User::all()->count() }}</h3>
                            <p>User Terdaftar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        @can('admin-role')
                            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#createModal">
                                Tambah User <i class="fas fa-plus-circle"></i>
                            </a>
                        @endcan
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>

                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div> --}}
            </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data User</h3>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                                    role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    @if (!empty($item->getRoleNames()))
                                                        @foreach ($item->getRoleNames() as $v)
                                                            <label class="badge badge-success">{{ $v }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>

                                                    <form action="{{ route('admin.user.destroy', $item) }}" method="POST">
                                                        @can('admin-role')
                                                            <a class="btn btn-xs btn-warning"
                                                                href="{{ route('admin.user.edit', $item) }}" data-toggle="tooltip"
                                                                title="Edit {{ $item->name }}"><i
                                                                    class=" fas fa-edit"></i></a>
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-xs btn-danger"
                                                                data-toggle="tooltip" title="Hapus {{ $item->name }}">
                                                                <i class="fas fa-trash-alt"
                                                                    onclick="return confirm('Are you sure you want to delete this item ?')"></i>
                                                            </button>
                                                        @endcan
                                                    </form>
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
                {!! Form::open(['route' => 'admin.user.store', 'method' => 'POST', 'files' => true]) !!}
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
