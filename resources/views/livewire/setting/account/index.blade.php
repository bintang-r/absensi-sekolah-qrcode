<div>
    <x-slot name="title">Pengaturan Akun</x-slot>

    <x-slot name="pageTitle">Pengaturan Akun</x-slot>

    <x-slot name="pagePretitle">Pengaturan</x-slot>

    <div class="row row-cards">
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body p-4 text-center">
                    <span class="avatar avatar-xl mb-3 avatar-rounded"
                        style="background-image: url({{ auth()->user()->avatarUrl() ?? '-' }})"></span>

                    <h3 class="m-0 mb-1">{{ auth()->user()->username ?? '-' }}</h3>

                    <div class="text-muted">{{ auth()->user()->email ?? '-' }}</div>

                    <div class="mt-3">
                        <span
                            class="badge bg-green-lt">{{ ucwords(str_replace('-', ' ', auth()->user()->role)) ?? '-' }}</span>
                    </div>
                </div>

                <div class="btn-group p-3" role="group" aria-label="Basic example">
                    <a href="{{ route('setting.profile.index') }}" class="btn btn-card py-3 btn-square">Profil</a>

                    <a href="{{ route('setting.account.index') }}" class="btn btn-card py-3 btn-square">Akun</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-8 mt-lg-3 mt-5">
            <x-alert />

            <form class="card" wire:submit.prevent="edit" autocomplete="off">
                <div class="card-header">Sunting Data Akun</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <x-form.input wire:model="username" name="username" label="Username" type="text"
                                placeholder="masukkan username" autofocus />

                            <x-form.input wire:model="surel" name="surel" label="Alamat Surel (email)"
                                placeholder="contoh@email.com" type="email" />

                            <div class="row">
                                <div
                                    class="col-lg-2 align-self-center text-lg-start text-center mt-lg-0 mt-4 mb-lg-0 mb-2 mb-lg-3">
                                    @if ($avatar)
                                        <span class="avatar avatar-md"
                                            style="background-image: url({{ $avatar->temporaryUrl() }})"></span>
                                    @else
                                        <span class="avatar avatar-md"
                                            style="background-image: url({{ $avatarUrl }})"></span>
                                    @endif
                                </div>

                                <div class="col-lg-auto col-12 mt-3 mt-lg-0">
                                    <x-form.input wire:model.lazy="avatar" name="avatar" label="Avatar" type="file"
                                        optional="Abaikan jika tidak ingin mengubah." />
                                </div>
                            </div>

                            <x-form.input wire:model.lazy="kataSandi" name="kataSandi" label="Kata Sandi (Password)"
                                placeholder="******" type="password" optional="Kosongkan jika tidak ingin mengubah." />

                            <x-form.input wire:model.lazy="konfirmasiKataSandi" name="konfirmasiKataSandi"
                                label="Konfirmasi Kata Sandi (Password)" placeholder="******" type="password"
                                optional="Kosongkan jika tidak ingin mengubah." />
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="btn-list justify-content-end">
                        <button type="reset" class="btn">Reset</button>

                        <x-datatable.button.save name="Simpan Perubahan" target="edit" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
