<x-layouts.auth title="Register">
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4"></h2>
            <form action="{{ route('register') }}" method="POST" autocomplete="off">

                @csrf

                <div class="mb-3">
                    <label class="form-label"></label>
                    <input class="form-control" type="text" name="" value="" required autofocus
                        placeholder="">
                </div>

                <div class="mb-2">
                    <label class="form-label">
                        <span>Kata Sandi</span>
                    </label>

                    <div class="input-group input-group-flat">
                        <input class="form-control" name="password" type="password" placeholder="******"
                            autocomplete="current-password" required>
                        <span class="input-group-text">
                            <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                                @include('partials.svg.eye')
                            </a>
                        </span>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">
                        <span>Konfirmasi Sandi</span>
                    </label>

                    <div class="input-group input-group-flat">
                        <input class="form-control" name="password_confirmation" type="password" placeholder="******"
                            autocomplete="current-password" required>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </div>

            </form>
        </div>
    </div>
</x-layouts.auth>
