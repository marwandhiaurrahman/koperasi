@extends('adminlte::page')

@section('title', 'Edit Anggota Koperasi')

@section('content_header')
    <h1>Edit Anggota Koperasi</h1>
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
            <x-adminlte-card title="Identisas Keanggotaan {{ $anggota->user->name }}" theme="secondary">
                <form action="{{ route('admin.anggota.update', $anggota->id) }}" id="myform" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <input name="id" value="{{ $anggota->id }}" hidden />
                            <input name="role" value="Anggota" hidden />
                            <x-adminlte-input name="kode" label="Kode Anggota" placeholder="Masukan Kode Anggota"
                                value="{{ $anggota->kode }}" readonly enable-old-support required />
                            <x-adminlte-select name="tipe" label="Tipe Anggota Koperasi" required enable-old-support>
                                <x-adminlte-options :options="['Honorer' => 'Honorer', 'PNS' => 'PNS', ]"
                                    placeholder="Pilih Tipe Anggota" selected="{{ $anggota->tipe }}" />
                            </x-adminlte-select>
                            <x-adminlte-select name="status" label="Status Anggota" required enable-old-support>
                                <x-adminlte-options :options="['0' => 'Aktif', '1' => 'Tidak Aktif', ]"
                                    placeholder="Pilih Status Anggota" selected="{{ $anggota->status }}" />
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-input name="nik" value="{{ $anggota->user->nik }}" label="NIK"
                                placeholder="Nomor Induk Kependudukan" enable-old-support />
                            <x-adminlte-input name="name" value="{{ $anggota->user->name }}" label="Nama"
                                placeholder="Nama Lengkap" enable-old-support />
                            <x-adminlte-input name="phone" value="{{ $anggota->user->phone }}" type="number"
                                label="Nomor HP / Telepon" placeholder="Nomor HP / Telepon yang dapat dihubungi"
                                enable-old-support />
                            <x-adminlte-input name="email" value="{{ $anggota->user->email }}" type="email" label="Email"
                                placeholder="Email" enable-old-support />
                            <x-adminlte-input name="username" value="{{ $anggota->user->username }}" label="Username"
                                placeholder="Username" enable-old-support />
                        </div>
                    </div>
                </form>
                <x-adminlte-button theme="danger" label="Kembali" onclick="window.location='{{ url()->previous() }}'" />
                <x-adminlte-button form="myform" type="submit" theme="success" label="Simpan" />
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalCustom" title="Tambah Anggota Koperasi" theme="success" v-centered static-backdrop
        scrollable>

    </x-adminlte-modal>
@stop

@section('plugins.Select2', true)
