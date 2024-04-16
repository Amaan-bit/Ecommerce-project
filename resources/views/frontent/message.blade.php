@if (session()->has('error'))
    <div class="alert alert-danger col-md-12 text-center" id="alert">
            {{session()->get('error')}}
    </div>
@elseif (session()->has('success'))
    <div class="alert alert-success col-md-12 text-center" id="alert">
        {{session()->get('success')}}
</div>
@endif