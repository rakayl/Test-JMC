<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Export</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
        }
        .date {
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Laporan Barang Masuk</div>
    </div>

    <table>
        <thead>
           <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Tanggal') }}</th>
                <th>{{ __('Kategori') }}</th>
                <th>{{ __('Sub Kategori') }}</th>
                <th>{{ __('Asal Barang') }}</th>
                <th>{{ __('Penerima') }}</th>
                <th>{{ __('Kode') }}</th>
                <th>{{ __('Nama barang') }}</th>
                <th>{{ __('Harga (Rp)') }}</th>
                <th>{{ __('Jumlah') }}</th>
                <th>{{ __('Total') }}</th>
                <th>{{ __('Status') }}</th>

            </tr>
        </thead>
        <tbody>
        @forelse($data ?? [] as $key => $item)
            @php
                $no = count($item['detail']);
                $firstRow = true;
            @endphp
            @foreach($item['detail'] as $keys => $value)
            <tr data-item="{{ $item->id }}" data-data="{{$item}}">
                @php
                    $total = $value->harga*$value->jumlah_barang;
                @endphp
                 <?php if ($firstRow): ?>
                    <td class="text-center group-header" rowspan="{{$no}}">
                        {{ $key+1 }}
                    </td>
                    <td class="text-center group-header" rowspan="{{$no}}">{{ date('d/m/Y H:i:s',strtotime($item->created_at)) }}</td>
                    <td class="text-center group-header" rowspan="{{$no}}">{{ $item->kategori->name_kategori }}</td>
                    <td class="text-center group-header" rowspan="{{$no}}">{{ $item->subkategori->nama_sub_kategori }}</td>
                    <td class="text-center group-header" rowspan="{{$no}}">{{ $item->asal_barang }}</td>
                    <td class="text-center group-header" rowspan="{{$no}}">{{ $item->user->name }}</td>
                    <?php $firstRow = false; ?>
                    <?php endif; ?>
                <td>{{ $value->kode }}</td>
                <td>{{ $value->nama_barang }}</td>
                <td>{{ number_format($value->harga, 0, ',', '.') }}</td>
                <td>{{ $value->jumlah_barang.' '.$value->satuan }}</td>
                <td>{{ number_format($total, 0, ',', '.') }}</td>
                <td class="text-center">@if($item->status) Verifikasi @else Belum Terverifikasi @endif</td>
            </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="11" class="text-center">{{ __('No data found') }}</td>
            </tr>
        @endforelse
    </tbody>
    </table>
</body>
</html>