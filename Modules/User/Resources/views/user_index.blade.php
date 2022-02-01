@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1>User / Pengguna</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $users->total() }}" text="User Terdaftar" theme="success"
                        icon="fas fa-users" />
                </div>
            </div>
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <x-adminlte-card title="Tabel Data User" theme="secondary" collapsible>
                <div class="dataTables_wrapper dataTable">
                    <div class="row">
                        <div class="col-md-8">
                            <x-adminlte-button label="Tambah" class="btn-sm" theme="success" title="Tambah User"
                                icon="fas fa-plus" data-toggle="modal" data-target="#modalCustom" />
                            {{-- <x-adminlte-button label="Export" class="btn-sm" theme="primary" title="Tooltip"
                                icon="fas fa-print" />
                            <x-adminlte-button label="Import" class="btn-sm" theme="warning" title="Tooltip"
                                icon="fas fa-upload" />
                            <x-adminlte-button label="Terhapus" class="btn-sm" theme="danger" title="Tooltip"
                                icon="fas fa-trash-alt" /> --}}
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('admin.user.index') }}" method="get">
                                <x-adminlte-input name="search" placeholder="Pencarian NIK / Nama" igroup-size="sm"
                                    value="{{ $request->search }}">
                                    <x-slot name="appendSlot">
                                        <x-adminlte-button type="submit" theme="outline-primary" label="Go!" />
                                    </x-slot>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-primary">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $heads = ['NIK', 'Name', 'Role', 'Gender', 'Umur', 'Email', 'Tgl Daftar', 'Action'];
                                $config['paging'] = false;
                                $config['lengthMenu'] = false;
                                $config['searching'] = false;
                                $config['info'] = false;
                                $config['responsive'] = true;
                                $config['order'] = [6, 'desc'];
                            @endphp
                            <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered
                                compressed>
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @foreach ($item->roles as $role)
                                                <span class="badge bg-success">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->gender }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} tahun</td>
                                        <td>
                                            @if ($item->email_verified_at == null)
                                                <i class="fas fa-user-times text-danger" data-toggle="tooltip"
                                                    title="Email User Belum Terverifikasi"></i>
                                            @else
                                                <i class="fas fa-user-check text-success" data-toggle="tooltip"
                                                    title="Email User Terverifikasi"></i>
                                            @endif
                                            {{ $item->email }}
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <form action="{{ route('admin.user.destroy', $item->id) }}" method="POST">
                                                <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit"
                                                    data-toggle="tooltip" title="Edit {{ $item->name }}"
                                                    onclick="window.location='{{ route('admin.user.edit', $item->id) }}'" />
                                                @csrf
                                                @method('DELETE')
                                                <x-adminlte-button class="btn-xs" theme="danger"
                                                    icon="fas fa-trash-alt" type="submit"
                                                    onclick="return confirm('Apakah anda akan menghapus {{ $item->name }} ?')" />
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="dataTables_info">
                                Tampil {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari total
                                {{ $users->total() }}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="dataTables_paginate pagination-sm">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalCustom" title="Tambah User" theme="success" v-centered static-backdrop scrollable>
        <form action="{{ route('admin.user.store') }}" id="myform" method="post">
            @csrf
            <x-adminlte-input name="nik" label="NIK" placeholder="Nomor Induk Kependudukan" enable-old-support required />
            <x-adminlte-input name="name" label="Nama" placeholder="Nama Lengkap" enable-old-support required />
            <x-adminlte-select2 id="role" name="role[]" label="Role / Jabatan" placeholder="Select a State"
                enable-old-support multiple required>
                <x-adminlte-options :options=$roles />
            </x-adminlte-select2>
            <x-adminlte-input name="phone" type="number" label="Nomor HP / Telepon"
                placeholder="Nomor HP / Telepon yang dapat dihubungi" enable-old-support />
            <x-adminlte-input name="email" type="email" label="Email" placeholder="Email" enable-old-support required />
            <x-adminlte-input name="username" label="Username" placeholder="Username" enable-old-support required />
            <x-adminlte-input name="password" type="password" label="Password" placeholder="Password" />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button form="myform" class="mr-auto" type="submit" theme="success" label="Simpan" />
            <x-adminlte-button theme="danger" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header  bg-success">
                    <h5 class="modal-title" id="modelHeading"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- {!! Form::open(['route' => 'admin.user.store', 'id' => 'productForm', 'name' => 'productForm', 'method' => 'POST', 'files' => true]) !!}
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
                        <label for="nik">NIK</label>
                        <input type="hidden" name="id" id="id">
                        {!! Form::text('nik', null, ['class' => 'form-control' . ($errors->has('nik') ? ' is-invalid' : ''), 'id' => 'nik', 'placeholder' => 'NIK', 'autofocus']) !!}
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'id' => 'name', 'placeholder' => 'Nama', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="role">Role / Jabatan</label>
                        {!! Form::select('role', $roles, null, ['class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''), 'id' => 'role', 'placeholder' => 'Pilih Role / Jabatan', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor Telephone</label>
                        {!! Form::text('phone', null, ['class' => 'form-control' . ($errors->has('phone') ? ' is-invalid' : ''), 'id' => 'phone', 'placeholder' => 'Nomor Telephone']) !!}
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        {!! Form::email('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'id' => 'email', 'placeholder' => 'Email', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        {!! Form::text('username', null, ['class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''), 'id' => 'username', 'placeholder' => 'Username', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'id' => 'password', 'placeholder' => 'Password']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!} --}}
            </div>
        </div>
    </div>

@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
