   <form action="/presensi/{{ $user->id }}/updateprofileadmin" method="POST" id="frmAdmin" enctype="multipart/form-data">
       @csrf
       <div class="col mb-2">
           <div class="form-group boxed">
               <div class="input-wrapper">
                   <input type="text" class="form-control" value="{{ $user->name }}" name="name"
                       placeholder="Username" autocomplete="off">
               </div>
           </div>
       </div>
       <div class="col mb-2">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $user->jabatan }}" name="jabatan"
                    placeholder="jabatan" autocomplete="off">
            </div>
        </div>
    </div>
       <div class="col mb-2">
           <div class="form-group boxed">
               <div class="input-wrapper">
                   <input type="text" class="form-control" value="{{ $user->email }}" name="email"
                       placeholder="Email" autocomplete="off">
               </div>
           </div>
       </div>
       <div class="col mb-2">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $user->no_handphone }}" name="no_handphone"
                    placeholder="no_handphone" autocomplete="off">
            </div>
        </div>
    </div>
       <div class="col mb-2">
           <div class="form-group boxed">
               <div class="input-wrapper">
                   <input type="password" class="form-control" name="password" placeholder="Password"
                       autocomplete="off">
               </div>
           </div>
       </div>
       <div class="row mt-2">
        <div class="col-12">
            <div class="form-label">Add Photo</div>
            <input type="file" name="photo" class="form-control">
        </div>
    </div>
       <div class="col mb-2">
           <div class="form-group boxed">
               <div class="input-wrapper">
                   <button type="submit" class="btn btn-primary btn-block" style="width: 100%; margin-top: 4px">
                       <ion-icon name="refresh-outline"></ion-icon>
                       Update
                   </button>
               </div>
           </div>
       </div>
   </form>
