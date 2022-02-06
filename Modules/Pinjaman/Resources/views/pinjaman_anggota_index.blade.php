@extends('adminlte::page')

@section('title', 'Pinjaman Anggota Koperasi')

@section('content_header')
    <h1 class="m-0 text-dark">Pinjaman Anggota Koperasi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    {{-- <x-adminlte-small-box title="{{ $anggotas->total() }}" text="Pinjaman Terdaftar" theme="success"
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


            <x-adminlte-card title="Tabel Pinjaman Anggota Koperasi" theme="secondary" collapsible>
                <div class="dataTables_wrapper dataTable">
                    <div class="row">
                        <div class="col-md-8">
                            <x-adminlte-button label="Tambah Pinjaman" class="btn-sm" theme="success"
                                title="Tambah Pinjaman" icon="fas fa-plus" data-toggle="modal"
                                data-target="#modalPinjaman" />
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('admin.anggota.index') }}" method="get">
                                <x-adminlte-input name="search" placeholder="Pencarian Kode / Nama Pinjaman"
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
                                //                             'kode',
                                // 'name',
                                // 'tanggal',
                                // 'anggota_id',
                                // 'tipe',
                                // 'plafon',
                                // 'waktu',
                                // 'angsuran',
                                // 'jasa',
                                // 'saldo',
                                // 'sisa_angsuran',
                                // 'validasi',
                                // 'admin_id',
                                // 'keterangan',
                                $heads = ['Kode Pinjaman', 'Tanggal', 'Nama Pinjaman', 'Anggota', 'Tipe', 'Plafon', 'Jasa', 'Saldo', 'Jatuh Tempo', 'Sisa Angsuran', 'Validasi', 'Action'];
                                $config['paging'] = false;
                                $config['lengthMenu'] = false;
                                $config['searching'] = false;
                                $config['info'] = false;
                                $config['responsive'] = true;
                            @endphp
                            <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" hoverable bordered
                                compressed>
                                @foreach ($pinjamans as $pinjaman)
                                    <tr>
                                        <td>{{ $pinjaman->kode }}</td>
                                        <td>{{ $pinjaman->tanggal }}</td>
                                        <td>{{ $pinjaman->name }}</td>
                                        <td>{{ $pinjaman->anggota->user->name }}</td>
                                        <td>{{ $pinjaman->tipe }}</td>
                                        <td>{{ money($pinjaman->plafon, 'IDR') }}</td>
                                        <td>{{ money($pinjaman->jasa, 'IDR') }}</td>
                                        <td>{{ money($pinjaman->saldo, 'IDR') }}</td>
                                        <td></td>
                                        <td>{{ $pinjaman->sisa_angsuran }}</td>
                                        <td>{{ $pinjaman->validasi }}</td>

                                        <td>
                                            <x-adminlte-button class="btn-xs" theme="primary" icon="fas fa-file"
                                                data-toggle="tooltip" title="Lihat Pinjaman {{ $pinjaman->kode }}"
                                                onclick="window.location='{{ route('anggota.pinjaman.show', $pinjaman->id) }}'" />
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalPinjaman" title="Tambah Pinjaman Anggota" theme="success" size='lg' v-centered
        static-backdrop scrollable>
        <form action="{{ route('admin.pinjaman.store') }}" id="myform" method="POST">
            @csrf
            @php
                $config = ['format' => 'DD-MM-YYYY'];
            @endphp
            <div class="row">
                <div class="col-md-5">
                    <x-adminlte-input-date name="tanggal" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}"
                        :config="$config" label="Tanggal Transaksi" placeholder="Masukan Tanggal Transaksi"
                        enable-old-support required>
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-gradient-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-input name="name" label="Nama Pinjaman" placeholder="Masukan Nama Pinjaman"
                        enable-old-support required />
                    <input type="hidden" name="validasi" value="Belum">
                    <x-adminlte-select2 name="anggota_id" label="Pengguna Transaksi" required enable-old-support>
                        @foreach ($anggotas as $angggota)
                            <option value="{{ $angggota->id }}">{{ $angggota->user->name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-textarea name="keterangan" label="Keterangan Pinjaman"
                        placeholder="Masukan Keterangan Pinjaman" enable-old-support required />
                    <x-adminlte-input name="user_id" label="Admin Transaksi" value="{{ Auth::user()->name }}" readonly
                        placeholder="Masukan Admin Transaksi" enable-old-support required />
                </div>
                <div class="col-md-7">
                    <x-adminlte-select2 name="jenis" label="Jenis Simpanan">
                        <x-adminlte-options :options="$jenis_transaksis" placeholder="Pilih Jenis Transaksi" />
                    </x-adminlte-select2>
                    <x-adminlte-input name="plafon" type="number" label="Plafon Pinjaman (Rupiah)"
                        placeholder="Masukan Plafon Pinjaman" enable-old-support required />
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input tipe" type="radio" id="pakeangsuran" value=0
                                        name="tipe" required>
                                    <label for="pakeangsuran" class="custom-control-label">Angsuran</label>
                                </div>
                                <div class="custom-control custom-radio ">
                                    <input class="custom-control-input tipe" type="radio" id="tidakangsuran" value=1
                                        name="tipe" required>
                                    <label for="tidakangsuran" class="custom-control-label">Tidak Angsuran</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <x-adminlte-input name="waktu" type="number" label="Jangka Waktu Angsuran (Bulan)"
                                placeholder="Jangka Waktu Angsuran Pinjaman" enable-old-support required />
                        </div>
                    </div>
                    <x-adminlte-input name="angsuran" type="number" readonly label="Angsuran Pinjaman (Rupiah)"
                        placeholder="Masukan Angsuran Pinjaman" enable-old-support required />
                    <div class="row">
                        <div class="col-md-8">
                            <x-adminlte-input name="jasa" type="number" readonly label="Jasa Pinjaman (Rupiah)"
                                placeholder="Nilai Jasa Pinjaman" enable-old-support required />
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-input name="persentasi_jasa" type="number" value="1" label="Persentasi Jasa (%)"
                                placeholder="Nilai Persentasi Jasa Pinjaman" readonly enable-old-support />
                        </div>
                    </div>
                </div>
            </div>
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
@section('js')
    <script>
        $(document).ready(function() {
            function hitungAngsuran() {
                var plafon = $('#plafon').val();
                var waktu = $('#waktu').val();
                var angsuran = plafon / waktu;
                $('#angsuran').val(angsuran);
                hitungJasa();
            }

            function hitungJasa() {
                var plafon = $('#plafon').val();
                var persentase = $('#persentasi_jasa').val();
                var jasa = plafon * persentase / 100;
                $('#jasa').val(jasa);
            }

            $('input[type=radio][name=tipe]').change(function() {
                if (this.value == 0) {
                    $('#waktu').val(10);
                    hitungAngsuran();
                } else if (this.value == 1) {
                    $('#waktu').val(1);
                    $('#angsuran').val(0);
                    hitungJasa();
                }
            });
            $("#plafon").bind("change paste keyup", function() {
                hitungAngsuran();
            });
            $("#waktu").bind("change paste keyup", function() {
                hitungAngsuran();
            });

        });
    </script>
@endsection
