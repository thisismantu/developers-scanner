<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="row">
        <div class="col">
            <div class="pagetitle">
                <h1>{{ $title }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        @foreach ($breadcrumbs as $key => $breadData)
                            <li class="breadcrumb-item"><a href="{{ $key }}">{{ $breadData }}</a></li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col text-end">
            @if (Auth::user()->is_admin)
                <x-responsive-nav-link :href="route('projects.create')" :active="request()->routeIs('projects')" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> {{ 'Add New' }}
                </x-responsive-nav-link>
            @endif
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title }}</h5>
                        <table class="table table-sm datatable2 mt-3">
                            <thead class="bg-light">
                                <tr>
                                    <th width="3%">S.No.</th>
                                    <th width="13%">Project Name</th>
                                    <th width="10%">Company</th>
                                    <th width="21%">Description</th>
                                    <th width="5%">Target</th>
                                    <th width="5%">Scan Engine</th>
                                    <th width="5%">Scan Schedule</th>
                                    <th width="5%">Start Date</th>
                                    <th width="5%">End Date</th>
                                    <th width="5%">Created By</th>
                                    <th width="5%">Created At</th>
                                    <th width="5%">Status</th>
                                    <th width="5%">Reports</th>
                                    <th width="5%">Action</th>
                                    @if (Auth::user()->is_admin)
                                        <th width="5%">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($response as $dataLine)
                                    <form method="post" action="{{ Route('projects.destroy', $dataLine->id) }}">
                                        @method('DELETE')
                                        @csrf
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $dataLine->name }}</td>
                                            <td>{{ $dataLine->company_name }}</td>
                                            <td>{{ $dataLine->description }}</td>
                                            <td>{{ $dataLine->targets }}</td>
                                            <td>{{ $dataLine->scan_engine }}</td>
                                            <td>{{ $dataLine->scan_schedule }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dataLine->start_at)->format('Y-m-d') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dataLine->end_at)->format('Y-m-d') }}</td>
                                            <td>{{ $dataLine->username }}</td>
                                            <td>{{ $dataLine->created_at }}</td>
                                            <td>
                                                @if (is_null($dataLine->scan_id))
                                                    <a class="badge bg-warning">Pending</a>
                                                @else
                                                    <a class="badge bg-success">Completed</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if (is_null($dataLine->scan_id))
                                                    <span class="badge bg-secondary">Pending</span>
                                                @else
                                                    <a href="{{ $dataLine->reports }}" class="badge bg-dark"
                                                        download><i class="bi bi-download"></i> Reports</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!is_null($dataLine->reports))
                                                    <span class="badge bg-secondary">...</span>
                                                @else
                                                    <a href="{{ Route('projects.scaning', encrypt($dataLine->id)) }}"
                                                        onclick="return confirm('do you want to Scaning?');"
                                                        class="badge bg-primary"><i class="bi bi-arrow-clockwise"></i>
                                                        Scan</a>
                                                @endif
                                            </td>
                                            @if (Auth::user()->is_admin)
                                                <td><button type="submit"
                                                        onclick="return confirm('Do you want to Trash';);"
                                                        class="btn btn-sm"><i
                                                            class="bi bi-trash text-danger"></i></button>
                                                    <a href="{{ Route('projects.edit', $dataLine->id) }}"><i
                                                            class="bi bi-pencil-square text-primary"></i></a>
                                                </td>
                                            @endif
                                        </tr>
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $response->links('vendor.pagination.bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
