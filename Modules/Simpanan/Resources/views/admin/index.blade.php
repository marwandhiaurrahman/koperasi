@extends('adminlte::page')

@section('title', 'Simpanan '.$time->monthName.' '.$time->year)

@section('content_header')
    <h1 class="m-0 text-dark">Simpanan {{ $time->monthName }} {{ $time->year }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h4>
                                {{ money($transaksis->whereIn('jenis', ['Simpanan Wajib', 'Simpanan Pokok', 'Simpanan Mana Suka'])->sum('nominal'), 'IDR') }},-
                            </h4>
                            <p>Total Simpanan </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#createModal">
                            Info Transaksi Simpanan <i class="fas fa-info-circle"></i>
                        </a>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h4>5 Transaksi Hari Ini</h4>
                            <p>Total Rp. 4.530.000</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Info Transaksi Simpanan <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div> --}}
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-arrow-down"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">
                                {{ money(
    $transaksis->where('tipe', 'Debit')->whereIn('jenis', ['Simpanan Wajib', 'Simpanan Pokok', 'Simpanan Mana Suka'])->sum('nominal'),
    'IDR',
) }},-
                            </span>
                            <span class="info-box-text">Simpanan Masuk</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-arrow-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">
                                {{ money(
    abs(
        $transaksis->where('tipe', 'Kredit')->whereIn('jenis', ['Simpanan Wajib', 'Simpanan Pokok', 'Simpanan Mana Suka'])->sum('nominal'),
    ),
    'IDR',
) }},-
                            </span>
                            <span class="info-box-text">Simpanan Keluar</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data Simpanan</h3>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline center"
                                    role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align:center">No.</th>
                                            <th rowspan="2" style="text-align:center">Nama Anggota</th>
                                            <th colspan="3" style="text-align:center">Simpanan</th>
                                            <th rowspan="2" style="text-align:center">Total Simpanan</th>
                                            <th rowspan="2" style="text-align:center">Action</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align:center">Pokok</th>
                                            <th style="text-align:center">Wajib</th>
                                            <th style="text-align:center">Mana Suka</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td style="text-align:right">
                                                    {{ money($item->transaksis->where('jenis', 'Simpanan Pokok')->sum('nominal'), 'IDR') }}
                                                </td>
                                                <td style="text-align:right">
                                                    {{ money($item->transaksis->where('jenis', 'Simpanan Wajib')->sum('nominal'), 'IDR') }}
                                                </td>
                                                <td style="text-align:right">
                                                    {{ money($item->transaksis->where('jenis', 'Simpanan Mana Suka')->sum('nominal'), 'IDR') }}
                                                </td>
                                                <td style="text-align:right">
                                                    {{ money($item->transaksis->whereIn('jenis', ['Simpanan Mana Suka', 'Simpanan Pokok', 'Simpanan Wajib'])->sum('nominal'), 'IDR') }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-xs btn-warning"
                                                    href="{{ route('admin.simpanan.show', $item) }}" data-toggle="tooltip"
                                                    title="Lihat Simpanan {{ $item->name }}"><i class=" fas fa-eye"></i></a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Total</th>
                                            <th style="text-align:right">
                                                {{ money($transaksis->where('jenis', 'Simpanan Pokok')->sum('nominal'), 'IDR') }}
                                            </th>
                                            <th style="text-align:right">
                                                {{ money($transaksis->where('jenis', 'Simpanan Wajib')->sum('nominal'), 'IDR') }}
                                            </th>
                                            <th style="text-align:right">
                                                {{ money($transaksis->where('jenis', 'Simpanan Mana Suka')->sum('nominal'), 'IDR') }}
                                            </th>
                                            <th style="text-align:right">
                                                {{ money($transaksis->whereIn('jenis', ['Simpanan Wajib', 'Simpanan Pokok', 'Simpanan Mana Suka'])->sum('nominal'), 'IDR') }}
                                            </th>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('js')
    <script type="text/javascript">
        @if ($errors->any())
            $('#createModal').modal('show');
        @endif
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel", "pdf", "print", "colvis"],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
