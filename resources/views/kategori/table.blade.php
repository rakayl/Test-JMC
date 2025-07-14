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
            <th>{{ __('Kode') }}</th>
            <th>{{ __('Nama') }}</th>
            
        </tr>
    </thead>
    <tbody>
        @forelse($data ?? [] as $key => $item)
            <tr data-item="{{ $item->kode_kategori }}" data-data="{{$item}}">
                <td>
                    {{ $key+1 }}
                </td>
                <td>
                     @include('admin.components.link.info-default',[
                        'class'         => "edit-modal-button",
                    ])  
                   
                    @include('admin.components.link.delete-default',[
                        'class'         => "delete-modal-button",
                        'title'         => 'ingin menghapus kategori ini ?'
                    ])
                </td>
                <td>{{ $item->kode_kategori }}</td>
                <td>{{ $item->name_kategori }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">{{ __('No data found') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>
