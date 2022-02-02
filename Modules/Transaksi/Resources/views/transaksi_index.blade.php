@extends('adminlte::page')

@section('title', 'Data Transaksi')

@section('content_header')
    <h1 class="m-0 text-dark">Data Transaksi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $transaksis->total() }}" text="Total Transaksi" theme="success"
                        icon="fas fa-user-friends" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-info-box title="Belum Validasi"
                        text="{{ money($nominal_debit - $nominal_kredit, 'IDR') }}" icon="fas fa-lg fa-download"
                        icon-theme="purple" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-info-box title="Transaksi Debit" text="1205" icon="fas fa-lg fa-download"
                        icon-theme="purple" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-info-box title="Transaksi Kredit" text="1205" icon="fas fa-lg fa-download"
                        icon-theme="purple" />
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
            <x-adminlte-card title="Tabel Data Transaksi" theme="secondary" collapsible>
                <div class="dataTables_wrapper dataTable">
                    <div class="row">
                        <div class="col-md-8">
                            <x-adminlte-button label="Tambah" class="btn-sm" theme="success" title="Tambah User"
                                icon="fas fa-plus" data-toggle="modal" data-target="#createModal" />
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('admin.anggota.index') }}" method="get">
                                <x-adminlte-input name="search" placeholder="Pencarian Kode / Nama Data Transaksi"
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
                                $heads = ['No.', 'Tanggal', 'Kode', 'Nama Anggota', 'Data Transaksi', 'Keterangan', 'Debit', 'Kredit', 'Validasi', 'Action'];
                                $config['paging'] = false;
                                $config['lengthMenu'] = false;
                                $config['searching'] = false;
                                $config['info'] = false;
                                $config['responsive'] = true;
                            @endphp
                            <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered
                                compressed>
                                @foreach ($transaksis as $item)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->anggota->name }}</td>
                                        <td>{{ $item->jenis_transaksi->name }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td class="text-right">
                                            @if ($item->tipe == 'Debit')
                                                {{ money($item->nominal, 'IDR') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if ($item->tipe == 'Kredit')
                                                {{ money($item->nominal, 'IDR') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->validasi == 'Belum')
                                                <span class="badge bg-danger">Belum</span>
                                            @else
                                                <span class="badge bg-success">Sudah</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.transaksi.destroy', $item->id) }}"
                                                method="POST">
                                                <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit"
                                                    data-toggle="tooltip" title="Edit {{ $item->kode }}"
                                                    onclick="window.location='{{ route('admin.transaksi.edit', $item->id) }}'" />
                                                @csrf
                                                @method('DELETE')
                                                <x-adminlte-button class="btn-xs" theme="danger"
                                                    icon="fas fa-trash-alt" type="submit"
                                                    onclick="return confirm('Apakah anda akan menghapus Transaksi {{ $item->kode }} ?')" />
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-right">Total</th>
                                        <th class="text-right">
                                            {{ money($nominal_debit, 'IDR') }}
                                        <th class="text-right">
                                            {{ money($nominal_kredit, 'IDR') }}
                                        </th>
                                        <th>{{ money($nominal_debit - $nominal_kredit, 'IDR') }}
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </x-adminlte-datatable>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="dataTables_info">
                                Tampil {{ $transaksis->firstItem() }} sampai {{ $transaksis->lastItem() }}
                                dari total
                                {{ $transaksis->total() }}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="dataTables_paginate pagination-sm">
                                {{ $transaksis->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="createModal" title="Tambah Transaksi" theme="success" v-centered static-backdrop scrollable>
        <form action="{{ route('admin.transaksi.store') }}" id="myform" method="POST">
            @csrf
            @php
                $config = ['format' => 'DD-MM-YYYY'];
            @endphp
            <x-adminlte-input-date name="tanggal" value="{{ \Carbon\Carbon::now() }}" :config="$config"
                label="Tanggal Transaksi" placeholder="Masukan Tanggal Transaksi">
                <x-slot name="appendSlot">
                    <div class="input-group-text bg-gradient-primary">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-input-date>
            <x-adminlte-select2 name="anggota_id" label="Pengguna Transaksi">
                <x-adminlte-options :options="$anggotas" placeholder="Pilih User Transaksi" />
            </x-adminlte-select2>
            <x-adminlte-select2 name="jenis" label="Jenis Transaksi">
                <x-adminlte-options :options="$jenis_transaksis" placeholder="Pilih Jenis Transaksi" />
            </x-adminlte-select2>
            <x-adminlte-select name="tipe" label="Tipe Transaksi">
                <x-adminlte-options :options="['Debit'=>'Debit', 'Kredit'=>'Kredit']" placeholder="Pilih Tipe Transaksi" />
            </x-adminlte-select>
            <x-adminlte-input name="nominal" type="number" label="Nominal Transaksi"
                placeholder="Masukan Nominal Transaksi" />
            <x-adminlte-textarea name="keterangan" label="Keterangan Transaksi"
                placeholder="Masukan Keterangan Transaksi" />
            <x-adminlte-input name="user_id" label="Admin Transaksi" value="{{ Auth::user()->name }}" readonly
                placeholder="Masukan Admin Transaksi" />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button form="myform" class="mr-auto" type="submit" theme="success" label="Simpan" />
            <x-adminlte-button theme="danger" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
