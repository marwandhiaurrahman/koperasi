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
            <x-adminlte-card title="Identitas Anggota" theme="secondary" collapsible>
                <div class="row">
                    <div class="col-md-3">
                        <dl>
                            <dt>Kode Anggota</dt>
                            <dd>{{ $anggota->kode }}</dd>
                            <dt>Tipe</dt>
                            <dd>{{ $anggota->tipe }}</dd>
                            <dt>Status </dt>
                            <dd>
                                @if ($anggota->status == 0)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-3">
                        <dl>
                            <dt>NIK</dt>
                            <dd>{{ $anggota->user->nik }}</dd>
                            <dt>Nama</dt>
                            <dd>{{ $anggota->user->nama }}</dd>
                            <dt>Nomor Telepon </dt>
                            <dd>{{ $anggota->user->phone }}</dd>
                            <dt>Email </dt>
                            <dd>{{ $anggota->user->email }}</dd>
                        </dl>
                    </div>
                </div>
            </x-adminlte-card>
            <x-adminlte-card title="Jenis Simpanan Anggota" theme="secondary" collapsible>
                @php
                    $heads = ['No.', 'Jenis Simpanan', 'Total Debit', 'Total Kredit', 'Saldo'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['searching'] = false;
                    $config['info'] = false;
                    $config['responsive'] = true;
                @endphp
                <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" hoverable bordered compressed>
                    @foreach ($jenis_simpanan as $jenis)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $jenis->name }} ({{ $jenis->kode }})</td>
                            <td class="text-right">
                                {{ money($transaksis->where('jenis', $jenis->kode)->where('tipe', 'Debit')->sum('nominal'),'IDR') }}
                            </td>
                            <td class="text-right">
                                {{ money($transaksis->where('jenis', $jenis->kode)->where('tipe', 'Kredit')->sum('nominal'),'IDR') }}
                            </td>
                            <td class="text-right">
                                {{ money($transaksis->where('jenis', $jenis->kode)->where('tipe', 'Debit')->sum('nominal') - $transaksis->where('jenis', $jenis->kode)->where('tipe', 'Debit')->sum('nominal'),'IDR') }}
                            </td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="2">
                                Total
                            </th>
                            <th class="text-right">
                                {{ money($transaksis->where('tipe', 'Debit')->sum('nominal'), 'IDR') }}
                            </th>
                            <th class="text-right">
                                {{ money($transaksis->where('tipe', 'Kredit')->sum('nominal'), 'IDR') }}
                            </th>
                            <th class="text-right">
                                {{ money($transaksis->where('tipe', 'Debit')->sum('nominal') - $transaksis->where('tipe', 'Kredit')->sum('nominal'),'IDR') }}
                            </th>
                        </tr>
                    </tfoot>
                </x-adminlte-datatable>
            </x-adminlte-card>

            <x-adminlte-card title="Tabel Transaksi Simpanan" theme="secondary" collapsible>
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
                                @foreach ($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $transaksi->created_at }}</td>
                                        <td>{{ $transaksi->kode }}</td>
                                        <td>{{ $transaksi->anggota->user->name }}</td>
                                        <td>{{ $transaksi->jenis_transaksi->name }}</td>
                                        <td>{{ $transaksi->keterangan }}</td>
                                        <td class="text-right">
                                            @if ($transaksi->tipe == 'Debit')
                                                {{ money($transaksi->nominal, 'IDR') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if ($transaksi->tipe == 'Kredit')
                                                {{ money($transaksi->nominal, 'IDR') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaksi->validasi == 'Belum')
                                                <span class="badge bg-danger">Belum</span>
                                            @else
                                                <span class="badge bg-success">Sudah</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}"
                                                method="POST">
                                                <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit"
                                                    data-toggle="tooltip" title="Edit {{ $transaksi->kode }}"
                                                    onclick="window.location='{{ route('admin.transaksi.edit', $transaksi->id) }}'" />
                                                @csrf
                                                @method('DELETE')
                                                <x-adminlte-button class="btn-xs" theme="danger"
                                                    icon="fas fa-trash-alt" type="submit"
                                                    onclick="return confirm('Apakah anda akan menghapus Transaksi {{ $transaksi->kode }} ?')" />
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-right">Total</th>
                                        <th class="text-right">
                                            {{ money($transaksis->where('tipe', 'Debit')->sum('nominal'), 'IDR') }}
                                        <th class="text-right">
                                            {{ money($transaksis->where('tipe', 'Kredit')->sum('nominal'), 'IDR') }}
                                        </th>
                                        <th>
                                            {{ money($transaksis->where('tipe', 'Debit')->sum('nominal') - $transaksis->where('tipe', 'Kredit')->sum('nominal'),'IDR') }}
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
@stop
@section('plugins.Datatables', true)
