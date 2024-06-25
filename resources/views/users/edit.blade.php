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
                        <form class="row g-3 needs-validation" action="{{ Route('users.update', $dataLine->id) }}"
                            method="post" novalidate>
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}" />
                            @if(Auth::user()->is_admin)
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_admin" {{$dataLine->is_admin==1?'checked':''}}
                                        id="invalidCheck">
                                    <label class="form-check-label" for="invalidCheck">
                                        Check for Admin
                                    </label>
                                </div>
                            </div>
                            @else
                            <input type="hidden" value="0" name="is_admin">
                            @endif

                            <div class="col-12">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full form-control" type="text"
                                    name="name" :value="$dataLine->name" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="col-12">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full form-control"
                                    placeholder="example@xyz.com *" type="email" name="email" :value="$dataLine->email"
                                    required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block mt-1 w-full form-control"
                                    placeholder="Min 8 Digits *" type="password" name="password" required
                                    autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="password_confirmation" class="block mt-1 w-full form-control"
                                    placeholder="Min 8 Digits *" type="password" name="password_confirmation" required
                                    autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
