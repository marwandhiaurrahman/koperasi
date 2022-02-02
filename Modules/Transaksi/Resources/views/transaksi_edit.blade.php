@extends('adminlte::page')

@section('title', 'Edit Transaksi')

@section('content_header')
    <h1>Edit Transaksi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <x-adminlte-card title="Detail Transaksi {{ $transaksi->name }}" theme="secondary">
                <form action="{{ route('admin.transaksi.store', $transaksi->id) }}" id="myform" method="POST">
                    @csrf
                    @php
                        $config = ['format' => 'DD-MM-YYYY'];
                    @endphp
                    <div class="row">
                        <div class="col-md-6">
                            <input name="id" value="{{ $transaksi->id }}" hidden />
                            <x-adminlte-input name="kode" label="Kode Transaksi" placeholder="Masukan Kode Transaksi"
                                value="{{ $transaksi->kode }}" enable-old-support required readonly />
                            <x-adminlte-input-date name="tanggal" value="{{ $transaksi->tanggal }}" :config="$config"
                                label="Tanggal Transaksi" placeholder="Masukan Tanggal Transaksi">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                            <x-adminlte-select2 name="anggota_id" label="Pengguna Transaksi">
                                <x-adminlte-options :options="$anggotas" selected="{{ $transaksi->anggota_id }}"
                                    placeholder="Pilih User Transaksi" />
                            </x-adminlte-select2>
                            <x-adminlte-select2 name="jenis" label="Jenis Transaksi">
                                <x-adminlte-options :options="$jenis_transaksis" selected="{{ $transaksi->jenis }}"
                                    placeholder="Pilih Jenis Transaksi" />
                            </x-adminlte-select2>
                            <x-adminlte-select name="tipe" label="Tipe Transaksi">
                                <x-adminlte-options :options="['Debit'=>'Debit', 'Kredit'=>'Kredit']"
                                    selected="{{ $transaksi->tipe }}" placeholder="Pilih Tipe Transaksi" />
                            </x-adminlte-select>
                            <x-adminlte-input name="nominal" value="{{ $transaksi->nominal }}" type="number"
                                label="Nominal Transaksi" placeholder="Masukan Nominal Transaksi" />
                            <x-adminlte-textarea name="keterangan" label="Keterangan Transaksi"
                                placeholder="Masukan Keterangan Transaksi">
                                {{ $transaksi->keterangan }}
                            </x-adminlte-textarea>
                            <x-adminlte-input name="user_id" label="Admin Transaksi" value="{{ Auth::user()->name }}"
                                readonly placeholder="Masukan Admin Transaksi" />
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="sudahvalidasi"
                                        {{ $transaksi->validasi == 'Sudah' ? 'checked' : null }} value="Sudah"
                                        name="validasi">
                                    <label for="sudahvalidasi" class="custom-control-label">Sudah Validasi</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="belumvalidasi"
                                        {{ $transaksi->validasi == 'Belum' ? 'checked' : null }} value="Belum"
                                        name="validasi">
                                    <label for="belumvalidasi" class="custom-control-label">Belum Validasi</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <x-adminlte-button theme="danger" label="Kembali" onclick="window.location='{{ url()->previous() }}'" />
                <x-adminlte-button form="myform" type="submit" theme="success" label="Simpan" />
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
