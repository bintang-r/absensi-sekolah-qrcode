<div class="modal fade" id="delete-confirmation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="modal-status bg-danger"></div>

            <div class="modal-body text-center py-4">
                <i class="las la-exclamation-triangle text-danger" style="font-size: 80px"></i>

                <h3>Apakah Anda yakin?</h3>

                <div class="text-muted">
                    Anda yakin ingin menghapus {{ count($this->selected) }} data? Apa yang telah Anda lakukan
                    tidak dapat dibatalkan.
                </div>
            </div>

            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn btn-white w-100" data-bs-dismiss="modal">
                                Batal
                            </a>
                        </div>

                        <div class="col">
                            <button wire:click="deleteSelected" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                Hapus {{ count($this->selected) }} data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
