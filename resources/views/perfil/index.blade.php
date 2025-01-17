@extends('layout.app')

@section('title')
    Editar Perfil: {{ auth()->user()->username }}
@endsection

@section('content')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form class="mt-10 md:mt-8" action="{{ route('perfil.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Username
                    </label>
                    <input type="text"
                            id="username"
                            name="username"
                            placeholder="Tu nombre de usuario"
                            class="border p-3 w-full rounded-lg @error('username') border-red-500
                            @enderror"
                            value="{{auth()->user()->username}}">
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen
                    </label>
                    <input type="file"
                            id="imagen"
                            name="imagen"
                            accept=".jpg,.jpeg,.png"
                            class="border p-3 w-full rounded-lg"
                            value="">
                </div>
                <p class="text-orange-950 mb-3">Si no desea cambiar la contraseña deje en blanco los siguientes campos</p>
                <div class="mb-5">
                    <label for="old_password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password Antiguo
                    </label>
                    <input type="password"
                            id="old_password"
                            name="old_password"
                            placeholder="Tu Password Antiguo"
                            class="border p-3 w-full rounded-lg @error('old_password') border-red-500
                            @enderror">
                    @error('old_password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password Actual
                    </label>
                    <input type="password"
                            id="password"
                            name="password"
                            placeholder="Tu password nuevo"
                            class="border p-3 w-full rounded-lg @error('password') border-red-500
                            @enderror">
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                    @if (session('mensaje'))
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ session('mensaje') }}
                        </p>
                    @endif
                </div>
                <input type="submit" value="Guardar Cambios" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white">
            </form>
        </div>
    </div>
@endsection