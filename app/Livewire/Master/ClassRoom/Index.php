<?php

namespace App\Livewire\Master\ClassRoom;

use App\Livewire\Traits\DataTable\WithBulkActions;
use App\Livewire\Traits\DataTable\WithCachedRows;
use App\Livewire\Traits\DataTable\WithPerPagePagination;
use App\Livewire\Traits\DataTable\WithSorting;
use App\Models\ClassRoom;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use WithBulkActions;
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;

    public $filters = [
        'search' => '',
    ];
    // FORM DATA
    public $namaKelas;
    public $deskripsi;
    public $statusAktif = true;

    // MODAL INITIALIZATION
    public $modalCreate = false;
    public $modalEdit = false;

    // IDENTITY
    public $classRoomId;

    // TOGGLE STATUS ACTIVE
    public function changeStatusActive($id){
        $classRoom = ClassRoom::findOrFail($id);
        $classRoom->status_active = !$classRoom->status_active;
        $classRoom->save();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil mengubah status aktif ruang kelas.",
        ]);

        return redirect()->back();
    }

    // MODAL HANDLERS
    public function closeModal(){
        $this->resetModal();
    }

    public function openModalCreate(){
        $this->resetModal();
        $this->modalCreate = true;
    }

    public function openModalEdit($id){
        $this->resetModal();
        $classRoom = ClassRoom::findOrFail($id);
        $this->classRoomId = $classRoom->id;
        $this->namaKelas = $classRoom->name_class;
        $this->deskripsi = $classRoom->description;
        $this->statusAktif = $classRoom->status_active;
        $this->modalEdit = true;
    }

    public function resetModal(){
        $this->reset([
            'modalCreate',
            'modalEdit',
            'namaKelas',
            'deskripsi',
            'statusAktif',
        ]);
    }

    // DELETE SELECTED
    public function deleteSelected()
    {
        $classRoom = ClassRoom::whereIn('id', $this->selected)->get();
        $deleteCount = $classRoom->count();

        foreach ($classRoom as $data) {
            if ($data->avatar) {
                File::delete(public_path('storage/' . $data->avatar));
            }
            $data->delete();
        }

        $this->reset();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menghapus $deleteCount data ruang kelas.",
        ]);

        return redirect()->back();
    }

    // GET DATA
    #[On('muat-ulang')]
    #[Computed()]
    public function rows()
    {
        $query = ClassRoom::query()
            ->when(!$this->sorts, fn($query) => $query->first())
            ->when($this->filters['search'], function ($query, $search) {
                $query->where('name_class', 'LIKE', "%$search%");
            })->latest();

        return $this->applyPagination($query);
    }

    // SAVE DATA
    public function save(){
        $this->validate([
            'namaKelas' => ['required', 'string','min:2', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'min:2'],
            'statusAktif' => ['boolean'],
        ]);

        try{
            DB::beginTransaction();

            if($this->classRoomId){
                $classRoom = ClassRoom::findOrFail($this->classRoomId);

                $classRoom->update([
                    'name_class' => $this->namaKelas,
                    'description' => $this->deskripsi,
                    'status_active' => $this->statusAktif,
                ]);
            }else{
                ClassRoom::create([
                    'name_class' => $this->namaKelas,
                    'description' => $this->deskripsi,
                    'status_active' => $this->statusAktif,
                ]);
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();

            logger()->error(
                '[pengguna] ' .
                    auth()->user()->username .
                    ' gagal menambahkan ruang kelas',
                [$e->getMessage()]
            );


            if($this->classRoomId){
                $message = "Gagal menyunting data ruang kelas.";
            }else{
                $message = "Gagal menambahkan data ruang kelas.";
            }

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => $message,
            ]);

            return redirect()->back();
        }

        if($this->classRoomId){
            $message = "Berhasil menyunting data ruang kelas.";
        }else{
            $message = "Berhasil menambahkan data ruang kelas.";
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => $message,
        ]);

        return redirect()->route('master.classroom.index');
    }

    #[Computed()]
    public function allData()
    {
        return ClassRoom::all();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function muatUlang()
    {
        $this->dispatch('muat-ulang');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.master.class-room.index');
    }
}
