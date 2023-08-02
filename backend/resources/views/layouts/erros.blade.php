@if (session('status'))
<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div class="col">
         <div class="h-100 bg-secondary rounded p-4">
            <div class="alert alert-success">
               {{ session('status') }}
            </div>
         </div>
      </div>
   </div>
</div>
@endif
@if (session('error'))
<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div class="col">
         <div class="h-100 bg-secondary rounded p-4">
            <div class="alert alert-danger">
               {{ session('error') }}
            </div>
         </div>
      </div>
   </div>
</div>
@endif 
@if (session('success'))
<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div class="col">
         <div class="h-100 bg-secondary rounded p-4">
            <div class="alert alert-success">
               {{ session('success') }}
            </div>
         </div>
      </div>
   </div>
</div>
@endif
@if ($errors->any())
<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div class="col">
         <div class="h-100 bg-secondary rounded p-4">
            <div class="alert alert-danger">
               <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
@endif