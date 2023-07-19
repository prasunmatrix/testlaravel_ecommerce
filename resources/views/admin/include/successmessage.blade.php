@if(Session::get('success', false))
    <?php $data = Session::get('success');?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-success alert-dismissible custom-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fa fa-check"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-success alert-dismissible custom-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-check"></i>
            {{ $data }}
        </div>
    @endif
@endif
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif