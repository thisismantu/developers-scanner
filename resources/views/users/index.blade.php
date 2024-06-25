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
            @if(Auth::user()->is_admin)
            <x-responsive-nav-link :href="route('users.create')" :active="request()->routeIs('projects')" class="btn btn-primary btn-sm">
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
                        <table class="table table-striped table-sm datatable2 mt-3">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">S.No.</th>
                                    <th>Role</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($response as $dataLine)
                                    <form method="post" action="{{ Route('users.destroy', $dataLine->id) }}">
                                        @method('DELETE')
                                        @csrf
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td><strong>{{ $dataLine->is_admin == 1 ? 'Admin' : 'User' }}</strong></td>
                                            <td>{{ $dataLine->name }}</td>
                                            <td>{{ $dataLine->email }}</td>
                                            <td>{{ $dataLine->created_at }}</td>
                                            <td>
                                                @if(Auth::user()->is_admin)
                                                <button type="submit"
                                                    onclick="return confirm('Do you want to Trash';);"
                                                    class="btn btn-sm"><i class="bi bi-trash text-danger"></i></button>
                                                @endif                                                    
                                                <a href="{{ Route('users.edit', $dataLine->id) }}"><i
                                                        class="bi bi-pencil-square text-primary"></i></a>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $response->links('vendor.pagination.bootstrap-5') !!}
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>


</x-app-layout>
