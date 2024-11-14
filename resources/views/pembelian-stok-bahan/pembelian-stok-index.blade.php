@extends('layouts')
@section('title', 'Pemesanan Bahan Baku - Family Bakery')
@section('content')
    <style>
        td {
            font-size: 1rem !important;
        }

        .dataTables_length,
        .dataTables_length select {
            font-size: 1em;
            margin: 10px 0;
            padding: 0;
            width: 50px !important;
        }
    </style>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label><strong>Status :</strong></label>
                    <select id="status" class="form-control" style="width: 200px">
                        <option value="">--Pilih Status--</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Dibayar">Dibayar</option>
                        <option value="Sedang Diantar">Sedang Diantar</option>

                    </select>
                </div>
            </div>
        </div>
        @can('pemesanan_bahan_baku-create')
            <a href="{{ route('pemesanan.create') }}" class="btn btn-sm btn-primary my-2 py-2 rounded"> <i class="fa fa-plus"
                    aria-hidden="true"></i> Tambah Data Pemesanan Bahan Baku</a>
        @endcan

        <div class="table-responsive">
            <table class="table table-hover table-light table-striped" id="dataTable">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Bahan Baku</th>
                        <th scope="col">Jumlah Pesanan</th>
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Status</th>
                        <th scope="col">Jumlah DP</th>
                        <th scope="col">Deadline DP</th>
                        <th scope="col">Sisa Pembayaran</th>
                        <th scope="col">Tanggal Pesanan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>

    </div>


    @include('vendor.sweetalert.alert')


@endsection

<script>
    $(document).ready(function() {
        $('#dataTable').on('click', '#delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            Swal.fire({
                title: 'Anda yakin?',
                text: "Anda tidak dapat mengembalikan tindakan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lanjutkan dengan tindakan hapus
                    window.location = "{{ route('pemesanan.delete', ':id') }}".replace(':id',
                        id);
                }
            })
        });

        $('#dataTable').DataTable({
            language: {
                paginate: {
                    previous: '<span class="fa fa-chevron-left"></span>',
                    next: '<span class="fa fa-chevron-right"></span>' // or '→'

                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('pemesanan.index') }}",
                data: function(d) {
                    d.status = $('#status').val(),
                        d.search = $('input[type="search"]').val()
                }
            },

            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama_bahan_baku',
                    name: 'nama_bahan_baku'
                },
                {
                    data: 'jumlah_pesanan',
                    name: 'jumlah_pesanan'
                },
                {
                    data: 'harga_satuan',
                    render: $.fn.dataTable.render.number(',', '.', 2, 'Rp.')
                },
                {
                    data: 'total_harga',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'status_pesanan',
                    name: 'status_pesanan'
                },
                {
                    data: 'dp',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'deadline_dp',
                    type: 'num',
                    render: {
                        _: 'deadline_dp',
                        sort: 'timestamp'
                    }
                },
                {
                    data: 'sisa_pembayaran',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'created_at',
                    type: 'num',
                    render: {
                        _: 'display',
                        sort: 'timestamp'
                    }
                },
                {
                    data: 'action',
                }
            ]
        });


        $('#status').change(function() {
            $('#dataTable').DataTable().ajax.reload();
        });



    });
</script>
