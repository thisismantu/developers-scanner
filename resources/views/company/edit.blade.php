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
                        <form class="row g-3 needs-validation" action="{{ Route('companies.update', $dataLine->id) }}"
                            method="post" novalidate>
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}" />
                            <div class="col-md-12">
                                <label for="company" class="form-label">Company Name *</label>
                                <textarea type="text" class="form-control" id="name" name="name" required>{{ $dataLine->name }}</textarea>
                                <div class="invalid-feedback">
                                    Please enter the company Name.
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" {{$dataLine->is_active==true?'checked':''}} value="1" name="is_active"
                                        id="invalidCheck">
                                    <label class="form-check-label" for="invalidCheck">
                                        Active/Inactive
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>


</x-app-layout>
