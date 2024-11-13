@extends('layouts')
@section('title', 'User Manajemen - Family Bakery')
@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="pull-right mb-3">
                        <a class="btn btn-sm btn-primary" href="/users/create"> <i class="fa fa-plus" aria-hidden="true"></i> Create
                            New User</a>
                </div>
            </div>
        </div>


        <table class="table table-hover table-striped" id="dataTable">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jabatan</th>
                    <th>Tanggal ditambahkan</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>{{ $user->role }}
                        </td>
                        <td>{{ $user->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                        <td>

                            <a class="btn btn-md btn-primary" href="/users/{{ $user->id }}/edit">Edit</a>
                            <form action="/users/{{ $user->id }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-md btn-danger">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                paginate: {
                    previous: '<span class="fa fa-chevron-left"></span>',
                    next: '<span class="fa fa-chevron-right"></span>' // or '→'

                }
            }
        });
    });
</script>
