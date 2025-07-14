<style>
    .custom-table {
        width: 100%;
    }
    
    .custom-table td, 
    .custom-table th {
        text-align: left !important;
        padding: 12px;
        vertical-align: middle;
    }

    .custom-table tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }

    .user-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .user-list li img {
        min-width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
    }

    .badge--success {
        background-color: #28a745;
        color: white;
    }
</style>

<table class="custom-table">
    <thead>
        <tr>
            <th>{{ __('No') }}</th>
            <th>{{ __('Action') }}</th>
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
                    <td class="text-center group-header" rowspan="{{$no}}">
                         @include('admin.components.link.edit-default',[
                            'class'         => "edit-modal-button btn--info",
                            'href'          => url('barang/update/'.$item->id)
                        ])  

                        @include('admin.components.link.delete-default',[
                            'class'         => "delete-modal-button",
                            'title'         => 'ingin menghapus kategori ini ?'
                        ])
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
                <td data-detail='{{$value->id}}' class="text-center">
                    @if($value->status == 1) 
                    <div class="btn btn--default "><i class="lar la-check-circle" style="color:green;"></i><div>
                    @else @include('admin.components.link.verifikasi-default',[
                            'class'         => "verifikasi-modal-button",
                            'icon'         => "las la-minus-circle",
                            'title'         => 'ingin verifikasi barang ini ?'
                        ]) @endif
                </td>
            </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="11" class="text-center">{{ __('No data found') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>
