@extends('adminlte::page')

@section('title', 'Simpanan Anggota Koperasi')

@section('content_header')
    <h1 class="m-0 text-dark">Simpanan Anggota Koperasi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    {{-- <x-adminlte-small-box title="{{ $anggotas->total() }}" text="Simpanan Terdaftar" theme="success"
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
            <x-adminlte-card title="Tabel Simpanan Anggota Koperasi" theme="secondary" collapsible>
                <div class="dataTables_wrapper dataTable">
                    {{-- <div class="row">
                        <div class="col-md-8">
                            <x-adminlte-button label="Tambah" class="btn-sm" theme="success" title="Tambah User"
                                icon="fas fa-plus" data-toggle="modal" data-target="#createModal" />
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('admin.anggota.index') }}" method="get">
                                <x-adminlte-input name="search" placeholder="Pencarian Kode / Nama Simpanan"
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
                    </div> --}}
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $heads = ['No.', 'Kode Anggota', 'Nama', 'Simpanan Debit', 'Simpanan Kredit', 'Saldo', 'Action'];
                                $config['paging'] = false;
                                $config['lengthMenu'] = false;
                                $config['searching'] = false;
                                $config['info'] = false;
                                $config['responsive'] = true;
                            @endphp
                            <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered
                                compressed>
                                @foreach ($anggotas as $anggota)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $anggota->kode }}</td>
                                        <td>{{ $anggota->user->name }}</td>
                                        <td class="text-right">
                                            {{ money($transaksis->where('anggota_id', $anggota->id)->where('tipe', 'Debit')->sum('nominal'),'IDR') }}
                                        </td>
                                        <td class="text-right">
                                            {{ money($transaksis->where('anggota_id', $anggota->id)->where('tipe', 'Kredit')->sum('nominal'),'IDR') }}
                                        </td>
                                        <td>
                                            {{ money($transaksis->where('anggota_id', $anggota->id)->where('tipe', 'Debit')->sum('nominal') -$transaksis->where('anggota_id', $anggota->id)->where('tipe', 'Kredit')->sum('nominal'),'IDR') }}
                                        </td>
                                        <td>
                                            <x-adminlte-button class="btn-xs" theme="primary" icon="fas fa-file"
                                                data-toggle="tooltip" title="Lihat Simpanan {{ $anggota->user->name }}"
                                                onclick="window.location='{{ route('admin.simpanan.show', $anggota->id) }}'" />
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-5">
                            <div class="dataTables_info">
                                Tampil {{ $jenis_simpanans->firstItem() }} sampai {{ $jenis_simpanans->lastItem() }} dari total
                                {{ $jenis_simpanans->total() }}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="dataTables_paginate pagination-sm">
                                {{ $jenis_simpanans->links() }}
                            </div>
                        </div>
                    </div> --}}
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
