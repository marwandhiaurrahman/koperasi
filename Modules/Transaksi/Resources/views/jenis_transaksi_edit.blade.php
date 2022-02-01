@extends('adminlte::page')

@section('title', 'Edit Jenis Transaksi Koperasi')

@section('content_header')
    <h1>Edit Jenis Transaksi Koperasi</h1>
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
            <x-adminlte-card title="Detail Jenis Transaksi {{ $jenis_transaksi->name }}" theme="secondary">
                <form action="{{ route('admin.jenis_transaksi.store', $jenis_transaksi->id) }}" id="myform" method="POST">
                    @csrf
                    {{-- @method('PUT') --}}
                    <div class="row">
                        <div class="col-md-6">
                            <input name="id" value="{{ $jenis_transaksi->id }}" hidden />
                            <x-adminlte-input name="kode" label="Kode Jenis Transaksi"
                                placeholder="Masukan Kode Jenis Transaksi" value="{{ $jenis_transaksi->kode }}"
                                enable-old-support required />
                            <x-adminlte-input name="name" value="{{ $jenis_transaksi->name }}"
                                label="Nama Jenis Transaksi" placeholder="Nama Jenis Transaksi" enable-old-support />
                            <x-adminlte-input name="group" value="{{ $jenis_transaksi->group }}" label="Group Transaksi"
                                placeholder="Nama Group Transaksi" enable-old-support />
                            <x-adminlte-select name="status" label="Status Jenis Transaksi" required enable-old-support>
                                <x-adminlte-options :options="['0' => 'Aktif', '1' => 'Tidak Aktif', ]"
                                    placeholder="Pilih Status Jenis Transaksi"
                                    selected="{{ $jenis_transaksi->status }}" />
                            </x-adminlte-select>
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
