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
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-card title="Identitas Anggota" theme="secondary" collapsible>
                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                </div>
                <div class="col-md-6">
                    <x-adminlte-card title="Detail Pinjaman" theme="secondary" collapsible>
                        <div class="row">
                            <div class="col-md-4">
                                <dl>
                                    <dt>Kode Pinjaman</dt>
                                    <dd>{{ $pinjaman->kode }}</dd>
                                    <dt>Nama Pinjaman</dt>
                                    <dd>{{ $pinjaman->name }}</dd>
                                    <dt>Tipe </dt>
                                    <dd>
                                        @if ($pinjaman->tipe == 0)
                                            <span class="badge badge-success">Angsuran</span>
                                        @else
                                            <span class="badge badge-primary">Tidak Angsuran</span>
                                        @endif
                                    </dd>
                                    <dt>Anggota</dt>
                                    <dd>{{ $anggota->user->name }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-4">
                                <dl>
                                    <dt>Plafon</dt>
                                    <dd>{{ money($pinjaman->plafon, 'IDR') }}</dd>
                                    <dt>Jasa</dt>
                                    <dd>{{ money($pinjaman->jasa, 'IDR') }}</dd>
                                    <dt>Saldo</dt>
                                    <dd>{{ money($pinjaman->saldo, 'IDR') }}</dd>
                                    <dt>Angsuran</dt>
                                    <dd>{{ money($pinjaman->angsuran, 'IDR') }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-4">
                                <dl>
                                    <dt>Waktu</dt>
                                    <dd>{{ $pinjaman->waktu }} bulan</dd>
                                    <dt>Sisa Angsuran</dt>
                                    <dd>{{ $pinjaman->sisa_angsuran }}</dd>
                                    <dt>Validasi </dt>
                                    <dd>
                                        @if ($pinjaman->validasi == 'Sudah')
                                            <span class="badge badge-success">Sudah</span>
                                        @endif
                                        @if ($pinjaman->validasi == 'Belum')
                                            <span class="badge badge-warning">Belum</span>
                                        @endif
                                        @if ($pinjaman->validasi == 'Ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </x-adminlte-card>
                </div>
            </div>
            <x-adminlte-card title="Tabel Transaksi Simpanan" theme="secondary" collapsible>
                <div class="dataTables_wrapper dataTable">
                    <div class="row">
                        <div class="col-md-8">
                            <x-adminlte-button label="Bayar Angsuran" class="btn-sm" theme="primary"
                                title="Tambah User" icon="fas fa-plus" data-toggle="modal" data-target="#createModal" />
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
                                $config['order'] = [1, 'desc'];
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
                </div>
            </x-adminlte-card>
        </div>
    </div>

    <x-adminlte-modal id="createModal" title="Tambah Transaksi" theme="success" v-centered static-backdrop scrollable>
        <form action="{{ route('admin.angsuran.store') }}" id="myform" method="POST">
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
            <x-adminlte-input name="kode_pinjaman" label="Kode Pinjaman" placeholder="Masukan Kode Pinjaman" readonly
                value="{{ $pinjaman->kode }}" />
            <input type="hidden" name="pinjaman_id" value="{{ $pinjaman->id }}">
            <input type="hidden" name="tipe" value="Debit">
            <input type="hidden" name="validasi" value="Belum">
            @if ($pinjaman->tipe == 0)
                <x-adminlte-input name="sisa_angsuran" label="Angsuran Ke- " placeholder="Masukan Kode Pinjaman" readonly
                    value="{{ $pinjaman->sisa_angsuran }}" />
            @endif
            <x-adminlte-input name="anggota" label="Anggota Pinjaman" placeholder="Masukan Anggota Pinjaman" readonly
                value="{{ $pinjaman->anggota->user->name }}" />
            <input type="hidden" name="anggota_id" value="{{ $pinjaman->anggota->id }}">
            <x-adminlte-select2 name="jenis" label="Jenis Transaksi">
                <x-adminlte-options :options="$jenis_transaksis" placeholder="Pilih Jenis Transaksi" />
            </x-adminlte-select2>
            <x-adminlte-input name="nominal" type="number" label="Nominal Angsuran"
                placeholder="Masukan Nominal Angsruan" />
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
