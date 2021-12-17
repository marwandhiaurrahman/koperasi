@extends('adminlte::page')

@section('title', 'Profile ' . $user->name)

@section('content_header')
    <h1 class="m-0 text-dark">Profil {{ $user->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        {{-- <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg"
                            alt="User profile picture"> --}}
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ $user->anggota->kode }} <br>{{ $user->anggota->tipe }} </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        {{-- <li class="list-group-item">
                            <b>Followers</b> <a class="float-right">1,322</a>
                        </li>
                        <li class="list-group-item">
                            <b>Following</b> <a class="float-right">543</a>
                        </li> --}}
                        <li class="list-group-item">
                            <b>Total Transaksi</b> <a class="float-right">{{$user->transaksis->count()}} x</a>
                        </li>
                    </ul>

                    <a href="{{route('anggota.transaksi.index')}}" class="btn btn-primary btn-block"><b>Transaksi</b></a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            {{-- <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Education</strong>

                    <p class="text-muted">
                        B.S. in Computer Science from the University of Tennessee at Knoxville
                    </p>

                    <hr>

                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                    <p class="text-muted">Malibu, California</p>

                    <hr>

                    <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                    <p class="text-muted">
                        <span class="tag tag-danger">UI Design</span>
                        <span class="tag tag-success">Coding</span>
                        <span class="tag tag-info">Javascript</span>
                        <span class="tag tag-warning">PHP</span>
                        <span class="tag tag-primary">Node.js</span>
                    </p>

                    <hr>

                    <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim
                        neque.</p>
                </div>
            </div> --}}
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#biodata" data-toggle="tab">Biodata</a>
                        </li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="biodata">
                            {{-- <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience"
                                            placeholder="Experience"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form> --}}
                            {{-- {!! Form::open(['route' => 'admin.anggota.store', 'method' => 'POST', 'files' => true]) !!} --}}
                            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['profil.update', $user], 'files' => true]) !!}
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
                                    <label for="inputName">Kode</label>
                                    {!! Form::text('kode', $user->anggota->kode, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'id' => 'inputName', 'placeholder' => 'Kode ', 'readonly', 'required']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="inputName">Nama</label>
                                    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'id' => 'inputName', 'placeholder' => 'Nama', 'autofocus', 'required']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="inputAlamat">Alamat</label>
                                    {!! Form::textarea('alamat', null, ['class' => 'form-control' . ($errors->has('alamat') ? ' is-invalid' : ''), 'rows' => 3, 'id' => 'inputAlamat', 'placeholder' => 'Alamat', 'required']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="iTipe">Tipe Anggota</label>
                                    {!! Form::select('tipe', ['Honorer' => 'Honorer', 'PNS' => 'PNS (Pegawai Negeri Sipil)'],  $user->anggota->tipe, ['class' => 'form-control' . ($errors->has('tipe') ? ' is-invalid' : ''), 'id' => 'iTipe', 'placeholder' => 'Pilih Tipe Anggota', 'required']) !!}
                                </div>
                                {{-- {{dd($user->alamat)}} --}}
                                {!! Form::hidden('role', 'Anggota') !!}
                                {{-- <div class="form-group">
                                    <label for="inputRoles">Role / Jabatan</label>
                                    {!! Form::select('role', $roles, null, ['class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''), 'id' => 'inputRoles', 'placeholder' => 'Pilih Role / Jabatan', 'required']) !!}
                                </div> --}}
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
                                {{-- <div class="form-group">
                                    <label for="inputPassword">Password</label>
                                    {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'id' => 'inputPassword', 'placeholder' => 'Password', 'required']) !!}
                                </div> --}}
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
                                {{-- <button type="submit" class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> --}}
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@stop
