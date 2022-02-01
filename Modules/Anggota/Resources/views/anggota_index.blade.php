@extends('adminlte::page')

@section('title', 'Anggota Koperasi')

@section('content_header')
    <h1 class="m-0 text-dark">Anggota Koperasi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $anggotas->total() }}" text="Anggota Terdaftar" theme="success"
                        icon="fas fa-user-friends" />
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
                                icon="fas fa-plus" data-toggle="modal" data-target="#createModal" />
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('admin.anggota.index') }}" method="get">
                                <x-adminlte-input name="search" placeholder="Pencarian Kode / Nama Anggota" igroup-size="sm"
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
                                $heads = ['No.', 'Kode', 'Nama Anggota', 'Tipe', 'Phone', 'Email', 'Tgl Daftar', 'Status', 'Action'];
                                $config['paging'] = false;
                                $config['lengthMenu'] = false;
                                $config['searching'] = false;
                                $config['info'] = false;
                                $config['responsive'] = true;
                                $config['order'] = [6, 'desc'];
                            @endphp
                            <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered
                                compressed>
                                @foreach ($anggotas as $item)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->tipe }}</td>
                                        <td>{{ $item->user->phone }}</td>
                                        <td>{{ $item->user->email }}</td>
                                        <td>{{ $item->user->created_at }}</td>
                                        <td>
                                            @if ($item->status)
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @else
                                                <span class="badge bg-success">Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit"
                                                data-toggle="tooltip" title="Edit {{ $item->kode }}"
                                                onclick="window.location='{{ route('admin.anggota.edit', $item->id) }}'" />
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="dataTables_info">
                                Tampil {{ $anggotas->firstItem() }} sampai {{ $anggotas->lastItem() }} dari total
                                {{ $anggotas->total() }}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="dataTables_paginate pagination-sm">
                                {{ $anggotas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="createModal" title="Tambah Anggota Koperasi" theme="success" v-centered static-backdrop
        scrollable>
        <form action="{{ route('admin.anggota.store') }}" id="myform" method="POST">
            @csrf
            <x-adminlte-input name="kode" label="Kode Anggota" placeholder="Masukan Kode Anggota"
                value="{{ $kodeanggota }}" readonly enable-old-support required />
            <x-adminlte-input name="nik" label="NIK" placeholder="Nomor Induk Kependudukan" enable-old-support />
            <x-adminlte-input name="name" label="Nama" placeholder="Nama Lengkap" enable-old-support required />
            <x-adminlte-select name="tipe" label="Tipe Anggota Koperasi" required enable-old-support>
                <x-adminlte-options :options="['Honorer' => 'Honorer', 'PNS' => 'PNS', ]"
                    placeholder="Pilih Tipe Anggota" />
            </x-adminlte-select>
            <input type="hidden" name="role" value="Anggota">
            <x-adminlte-input name="phone" type="number" label="Nomor Telepon" placeholder="Nomor Telepon"
                enable-old-support />
            <x-adminlte-input name="email" type="email" label="Email" placeholder="Email" enable-old-support required />
            <x-adminlte-input name="username" label="Username" placeholder="Username" enable-old-support required />
            <x-adminlte-input name="password" type="password" label="Password" placeholder="Password" enable-old-support
                required />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button form="myform" class="mr-auto" type="submit" theme="success" label="Simpan" />
            <x-adminlte-button theme="danger" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
