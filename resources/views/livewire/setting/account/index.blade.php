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
                            class="badge bg-green-lt">{{ ucwords(str_replace('-', ' ', auth()->user()->roles)) ?? '-' }}</span>
                    </div>
                </div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('setting.profile.index') }}" class="btn btn-card py-3 btn-square">Profil</a>

                    <a href="{{ route('setting.account.index') }}" class="btn btn-card py-3 btn-square">Akun</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-8">
            <x-alert />

            <form class="card" wire:submit.prevent="edit" autocomplete="off">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <x-form.input wire:model="username" name="username" label="Username" type="text"
                                placeholder="masukkan username" autofocus />

                            <x-form.input wire:model="surel" name="surel" label="Alamat Surel (email)"
                                placeholder="contoh@email.com" type="email" />

                            <div class="row">
                                <div class="col-2">
                                    @if ($avatar)
                                        <span class="avatar avatar-md"
                                            style="background-image: url({{ $avatar->temporaryUrl() }})"></span>
                                    @else
                                        <span class="avatar avatar-md"
                                            style="background-image: url({{ $avatarUrl }})"></span>
                                    @endif
                                </div>

                                <div class="col">
                                    <x-form.input wire:model.lazy="avatar" name="avatar" label="Avatar" type="file"
                                        optional />
                                </div>
                            </div>

                            <x-form.input wire:model.lazy="kataSandi" name="kataSandi" label="Kata Sandi"
                                placeholder="******" type="password" optional />

                            <x-form.input wire:model.lazy="konfirmasiKataSandi" name="konfirmasiKataSandi"
                                label="Konfirmasi Kata Sandi" placeholder="******" type="password" />
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
