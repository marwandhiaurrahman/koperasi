@extends('adminlte::page')

@section('title', 'Jenis Transaksi Koperasi')

@section('content_header')
    <h1 class="m-0 text-dark">Jenis Transaksi Koperasi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    {{-- <x-adminlte-small-box title="{{ $anggotas->total() }}" text="Jenis Transaksi Terdaftar" theme="success"
                        icon="fas fa-user-friends" /> --}}
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
            <x-adminlte-card title="Tabel Jenis Transaksi" theme="secondary" collapsible>
                <div class="dataTables_wrapper dataTable">
                    <div class="row">
                        <div class="col-md-8">
                            <x-adminlte-button label="Tambah" class="btn-sm" theme="success" title="Tambah User"
                                icon="fas fa-plus" data-toggle="modal" data-target="#createModal" />
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('admin.anggota.index') }}" method="get">
                                <x-adminlte-input name="search" placeholder="Pencarian Kode / Nama Jenis Transaksi"
                                    igroup-size="sm" value="{{ $request->search }}">
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
                                $heads = ['No.', 'Kode', 'Jenis Transaksi', 'Group', 'Status', 'Action'];
                                $config['paging'] = false;
                                $config['lengthMenu'] = false;
                                $config['searching'] = false;
                                $config['info'] = false;
                                $config['responsive'] = true;
                            @endphp
                            <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered
                                compressed>
                                @foreach ($jenis_transaksis as $item)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->group }}</td>
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
                                                onclick="window.location='{{ route('admin.jenis_transaksi.edit', $item->id) }}'" />
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="dataTables_info">
                                Tampil {{ $jenis_transaksis->firstItem() }} sampai {{ $jenis_transaksis->lastItem() }}
                                dari total
                                {{ $jenis_transaksis->total() }}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="dataTables_paginate pagination-sm">
                                {{ $jenis_transaksis->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="createModal" title="Tambah Jenis Transaksi Koperasi" theme="success" v-centered static-backdrop
        scrollable>
        <form action="{{ route('admin.jenis_transaksi.store') }}" id="myform" method="POST">
            @csrf
            <x-adminlte-input name="name" label="Nama Jenis Transaksi" placeholder="Nama Jenis Transaksi" enable-old-support
                required />
            <x-adminlte-input name="kode" label="Kode Jenis Transaksi" placeholder="Kode Jenis Transaksi" enable-old-support
                required />
            <x-adminlte-input name="group" label="Group Transaksi" placeholder="Nama Group Transaksi" enable-old-support />
            <x-adminlte-select name="status" label="Status" required enable-old-support>
                <x-adminlte-options :options="['0' => 'Aktif', '1' => 'Tidak Aktif', ]"
                    placeholder="Pilih Status Jenis Transaksi" />
            </x-adminlte-select>
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button form="myform" class="mr-auto" type="submit" theme="success" label="Simpan" />
            <x-adminlte-button theme="danger" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
