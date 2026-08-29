@extends('adminlte::page')

@section('title', 'Activity Log')

@section('content_header')
    <h1>Activity Log</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Riwayat Aktivitas Sistem
        </h3>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Modul</th>
                        <th>Deskripsi</th>
                        <th>Perubahan</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($logs as $log)

                        <tr>

                            <td>
                                {{ $logs->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $log->created_at->format('d-m-Y H:i:s') }}
                            </td>

                            <td>
                                {{ $log->user->name ?? 'User telah dihapus' }}
                            </td>

                            <td>

                                @if($log->action === 'create')
                                    <span class="badge badge-success">
                                        CREATE
                                    </span>

                                @elseif($log->action === 'update')
                                    <span class="badge badge-warning">
                                        UPDATE
                                    </span>

                                @elseif($log->action === 'delete')
                                    <span class="badge badge-danger">
                                        DELETE
                                    </span>

                                @else
                                    <span class="badge badge-info">
                                        {{ strtoupper($log->action) }}
                                    </span>
                                @endif

                            </td>

                            <td>
                                {{ $log->module }}
                            </td>

                            <td>
                                {{ $log->description }}
                            </td>

                            <td>

                                @if($log->changes)

                                    <ul class="mb-0">

                                        @foreach($log->changes as $field => $change)

                                            <li>
                                                <strong>
                                                    {{ $field }}
                                                </strong>:

                                                <span class="text-danger">
                                                    {{ $change['old'] ?? '-' }}
                                                </span>

                                                →

                                                <span class="text-success">
                                                    {{ $change['new'] ?? '-' }}
                                                </span>
                                            </li>

                                        @endforeach

                                    </ul>

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada aktivitas.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $logs->links() }}
        </div>

    </div>

</div>

@stop
