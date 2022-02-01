@extends('adminlte::page')

@section('title', 'Edit Jenis Simpanan Koperasi')

@section('content_header')
    <h1>Edit Jenis Simpanan Koperasi</h1>
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
            <x-adminlte-card title="Detail Jenis Simpanan {{ $jenis_simpanan->name }}" theme="secondary">
                <form action="{{ route('admin.jenis_simpanan.store', $jenis_simpanan->id) }}" id="myform" method="POST">
                    @csrf
                    {{-- @method('PUT') --}}
                    <div class="row">
                        <div class="col-md-6">
                            <input name="id" value="{{ $jenis_simpanan->id }}" hidden />
                            <x-adminlte-input name="kode" label="Kode Anggota" placeholder="Masukan Kode Anggota"
                                value="{{ $jenis_simpanan->kode }}" enable-old-support required />
                            <x-adminlte-input name="name" value="{{ $jenis_simpanan->name }}" label="Nama"
                                placeholder="Nama Lengkap" enable-old-support />
                            <x-adminlte-select name="status" label="Status Anggota" required enable-old-support>
                                <x-adminlte-options :options="['0' => 'Aktif', '1' => 'Tidak Aktif', ]"
                                    placeholder="Pilih Status Anggota" selected="{{ $jenis_simpanan->status }}" />
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
