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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title }}</h5>
                        <form class="row g-3 needs-validation" action="{{ Route('projects.store') }}" method="post"
                            novalidate>
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}" />


                            <div class="col-md-12">
                                <label for="company" class="form-label">Company Name *</label>
                                <select class="form-control" id="company_id" name="company_id" required>
                                    <option value="">Choose...</option>
                                    @foreach ($companies as $companiesLine)
                                        <option value="{{ $companiesLine->id }}">{{ $companiesLine->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please enter the company Name.
                                </div>
                                <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                            </div>

                            <div class="col-md-12">
                                <label for="company" class="form-label">Project Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    value="{{ old('name') }}" />
                                <div class="invalid-feedback">
                                    Please enter Project Name.
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="col-md-12">
                                <label for="company" class="form-label">Description *</label>
                                <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
                                <div class="invalid-feedback">
                                    Please enter the Description.
                                </div>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            <div class="col-md-6">
                                <label for="company" class="form-label">Start Date *</label>
                                <input type="date" class="form-control" id="start_at" name="start_at" required
                                    value="{{ old('start_at') }}" />
                                <div class="invalid-feedback">
                                    Please enter the Start Date.
                                </div>
                                <x-input-error :messages="$errors->get('start_at')" class="mt-2" />
                            </div>
                            <div class="col-md-6">
                                <label for="company" class="form-label">End Date *</label>
                                <input type="date" class="form-control" id="end_at" name="end_at" required
                                    value="{{ old('end_at') }}" />
                                <div class="invalid-feedback">
                                    Please enter the End Date.
                                </div>
                                <x-input-error :messages="$errors->get('end_at')" class="mt-2" />
                            </div>
                            <div class="col-md-6">
                                <label for="targets" class="form-label">Targets *</label>
                                <input type="text" class="form-control" id="targets" name="targets" required
                                    value="{{ old('targets') }}" />
                                <div class="invalid-feedback">
                                    Please enter the Targets.
                                </div>
                                <x-input-error :messages="$errors->get('targets')" class="mt-2" />
                            </div>
                            <div class="col-md-6">
                                <label for="scan_engine" class="form-label">Scan Engine *</label>
                                <input type="text" class="form-control" id="scan_engine" name="scan_engine" required
                                    value="{{ old('scan_engine') }}" />
                                <div class="invalid-feedback">
                                    Please enter the Scan Engine.
                                </div>
                                <x-input-error :messages="$errors->get('scan_engine')" class="mt-2" />
                            </div>
                            <div class="col-md-12">
                                <label for="scan_schedule" class="form-label">Scan Schedule *</label>
                                <input type="text" class="form-control" id="scan_schedule" name="scan_schedule"
                                    required value="{{ old('scan_schedule') }}" />
                                <div class="invalid-feedback">
                                    Please enter the Scan Schedule.
                                </div>
                                <x-input-error :messages="$errors->get('scan_schedule')" class="mt-2" />
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>


</x-app-layout>
