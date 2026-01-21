<div class="col-md-4">
@foreach($data as $item)
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                @if($item->emp_image != '')
                <img class="profile-user-img img-fluid img-circle"
                    src="{{asset('public/employees/'.$item->emp_img)}}"
                    alt="User profile picture">
                @else
                <img class="profile-user-img img-fluid img-circle"
                    src="{{asset('public/employees/default.png')}}"
                    alt="User profile picture">
                @endif
            </div>
            <h3 class="profile-username text-center">{{$item->first_name}} {{$item->last_name}}</h3>
            <p class="text-muted text-center">{{$item->designation}} ({{$item->department}})</p>
        </div><!-- /.card-body -->
    </div><!-- /.card -->
@endforeach
</div>