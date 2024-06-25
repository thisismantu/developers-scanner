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
                                    <th>Project</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($response as $dataLine)
                                    <form method="post" action="{{ Route('project-mapping.update', $dataLine->id) }}">
                                        @csrf                                    
                                        <input type="hidden" name="user_id" value="{{$dataLine->id}}" />
                                        <tr>
                                            <td style="vertical-align: middle;" class="text-center">
                                                {{ $loop->iteration }}</td>
                                            <td style="vertical-align: middle;">
                                                <strong>{{ $dataLine->is_admin == 1 ? 'Admin' : 'User' }}</strong></td>
                                            <td style="vertical-align: middle;">{{ $dataLine->name }}</td>
                                            <td style="vertical-align: middle;">{{ $dataLine->email }}</td>
                                            <td style="vertical-align: middle;"><select class="form-control"
                                                    name="project_id[]" {{Auth::user()->is_admin==0?'disabled':''}}  multiple>
                                                    @foreach ($projects as $projectsLine)
                                                        <option value="{{ $projectsLine->id }}" {{in_array($projectsLine->id,\App\Models\ProjectMapping::whereUserId($dataLine->id)->pluck('project_id')->toArray())?'selected':''}}>
                                                            {{ $projectsLine->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="vertical-align: middle;">{{ $dataLine->created_at }}</td>
                                            <td style="vertical-align: middle;"><button type="submit" {{Auth::user()->is_admin==0?'disabled':''}}
                                                    onclick="return confirm('Do you want to Assigned';);"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-save"></i>
                                                    Save</button>
                                            </td>
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
