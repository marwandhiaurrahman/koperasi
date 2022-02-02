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
                        text="{{ money($nominal_transaksi->sum('nominal'), 'IDR') }}" icon="fas fa-lg fa-download"
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
                                            <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit"
                                                data-toggle="tooltip" title="Edit {{ $item->kode }}"
                                                onclick="window.location='{{ route('admin.jenis_transaksi.edit', $item->id) }}'" />
                                        </td>
                                    </tr>
                                @endforeach
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-right">Total</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Kredit</th>
                                        <th>{{ money($nominal_transaksi->sum('nominal'), 'IDR') }}</th>
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
            {{-- <div class="form-group">
                <label for="iKode">Kode Transaksi</label>
                {!! Form::text('kode', $kodetransaksi, ['class' => 'form-control' . ($errors->has('kode') ? ' is-invalid' : ''), 'id' => 'iKode', 'readonly', 'required']) !!}
            </div> --}}
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
            <x-adminlte-select2 name="anggota_id">
                <option>Option 1</option>
                <option disabled>Option 2</option>
                <option selected>Option 3</option>
            </x-adminlte-select2>

            {{-- <div class="form-group">
                <label for="iAnggota">Nama Anggota</label>
                {!! Form::select('anggota_id', $users, null, ['class' => 'form-control' . ($errors->has('anggota_id') ? ' is-invalid' : ''), 'id' => 'iAnggota', 'autofocus', 'placeholder' => 'Nama Anggota', 'required']) !!}
            </div> --}}
            {{-- <div class="form-group">
                <label for="iJenis">Jenis Transaksi</label>
                {!! Form::select('jenis', $debittransaksi, null, ['class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''), 'id' => 'iJenis', 'placeholder' => 'Jenis Transaksi', 'required']) !!}
            </div> --}}
            <div class="form-group">
                {!! Form::hidden('validasi', '0', ['readonly']) !!}
            </div>
            <div class="form-group">
                {!! Form::hidden('tipe', 'Debit', ['readonly']) !!}
            </div>
            <div class="form-group">
                <label for="iNominal">Nominal</label>
                {!! Form::number('nominal', null, ['class' => 'form-control' . ($errors->has('nominal') ? ' is-invalid' : ''), 'id' => 'iNominal', 'placeholder' => 'Nominal Pemasukan', 'required']) !!}
            </div>
            <div class="form-group">
                <label for="iKeterangan">Keterangan</label>
                {!! Form::textarea('keterangan', null, ['class' => 'form-control' . ($errors->has('keterangan') ? ' is-invalid' : ''), 'rows' => 3, 'id' => 'iKeterangan', 'placeholder' => 'Keterangan', 'required']) !!}
            </div>
            <div class="form-group">
                <label for="iUser">Administrator</label>
                {!! Form::text('user_id', Auth::user()->name, ['class' => 'form-control' . ($errors->has('user_id') ? ' is-invalid' : ''), 'id' => 'iUser', 'readonly', 'required']) !!}
                {!! Form::hidden('user_id', Auth::user()->id, ['readonly']) !!}
            </div>
            <x-adminlte-input name="name" label="Nama Data Transaksi" placeholder="Nama Data Transaksi" enable-old-support
                required />
            <x-adminlte-input name="kode" label="Kode Data Transaksi" placeholder="Kode Data Transaksi" enable-old-support
                required />
            <x-adminlte-input name="group" label="Group Transaksi" placeholder="Nama Group Transaksi" enable-old-support />
            <x-adminlte-select name="status" label="Status" required enable-old-support>
                <x-adminlte-options :options="['0' => 'Aktif', '1' => 'Tidak Aktif', ]"
                    placeholder="Pilih Status Data Transaksi" />
            </x-adminlte-select>
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
