 @push('styles')
     <style>
         .status-table {
             width: 100%;
             border-collapse: separate;
             border-spacing: 0 8px;
         }

         .status-table td {
             padding: 8px 12px;
             vertical-align: middle;
             font-size: 16px;
         }

         .status-label {
             font-weight: 600;
             color: #495057;
         }

         .status-value {
             font-weight: 700;
             padding: 4px 12px;
             border-radius: 6px;
             background: #f8f9fa;
             color: #dc3545;
             letter-spacing: 1px;
         }
     </style>
 @endpush

 <div>
     <x-slot name="title">Whatsapp Broadcast</x-slot>

     <x-slot name="pageTitle">Whatsapp Broadcast</x-slot>

     <x-slot name="pagePretitle">Atur Whatsapp Broadcast</x-slot>

     <div class="row">
         <div class="col-lg-6 col-12">
             <div class="card mb-3">
                 <div class="card card-count-data flex border border-green-lt">
                     <div class="card-body">
                         <div class="d-flex gap-3">
                             <div class="align-self-center">
                                 <div style="font-size: 60px" class="lab la-whatsapp text-white bg-green p-2 rounded-3">
                                 </div>
                             </div>

                             <div class="d-flex flex-column">
                                 <h2 class="my-1 text-black">Whasapp Broadcast</h2>
                                 <div class="d-flex justify-content-between gap-2">
                                     <button class="btn btn-green">Scan <span
                                             class="las la-qrcode ms-2 fs-2"></span></button>
                                     <button class="btn btn-cyan">Kirim<span
                                             class="lab la-telegram-plane ms-2 fs-2"></span></button>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="card mb-3">
                 <div class="card-body">
                     <table class="status-table">
                         <tr>
                             <td class="status-label">Status Scan</td>
                             <td>:</td>
                             <td>
                                 <span class="status-value">Tidak Aktif</span>
                             </td>
                         </tr>
                         <tr>
                             <td class="status-label">Status Server</td>
                             <td>:</td>
                             <td>
                                 <span class="status-value">Tidak Aktif</span>
                             </td>
                         </tr>
                     </table>
                 </div>

                 <div class="card-body d-flex gap-3">
                     <button class="btn btn-orange">Reset Server <span
                             class="las la-redo-alt fs-2 ms-2"></span></button>
                     <button class="btn btn-red">Keluar <span class="las la-times fs-2 ms-2"></span></button>
                 </div>
             </div>
         </div>

         <div class="col-lg-6 col-12">
             <form class="card" wire:submit.prevent="save" autocomplete="off">
                 <div class="card-header">
                     Konfigurasi Whatsapp Broadcast
                 </div>

                 <div class="card-body">
                     <div class="row">
                         <div class="col-12">
                             <x-form.input wire:model="nomorWhatsapp" name="nomorWhatsapp" label="Nomor Whatsapp"
                                 placeholder="masukkan nomor whatsapp" type="text" required autofocus />

                             <x-form.input wire:model="linkServer" name="linkServer" label="Whatsapp URL Konfigurasi"
                                 placeholder="masukkan link server / konfigurasi whatsapp" type="text" required />

                             <x-form.input wire:model="port" name="port" label="Whatsapp PORT Konfigurasi"
                                 placeholder="masukkan port link server" type="text" required />
                         </div>
                     </div>
                 </div>

                 <div class="card-footer">
                     <div class="btn-list justify-content-end">
                         <button type="reset" class="btn">Reset</button>

                         <x-datatable.button.save target="save" />
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </div>
