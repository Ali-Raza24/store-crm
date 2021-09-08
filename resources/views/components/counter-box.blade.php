<div class="col-{{$column}} {{$class}}">
    <div class="counter-box {{$border_color}}-border">
        <div class="counter-flexer">
            <div class="counter-col">
                <p class="dark-one font-weight-400">{{$title}}</p>
                <h2 class="{{$text_color}}-text font-weight-700" data-to="{{$total}}">{{$total}}</h2>
            </div>
            @if($icon)
                <div class="counter-col">
                    <img alt="" src="{{asset('business_assets/images')."/".$icon}}" class="counter-icon">
                </div>
            @endif
        </div>
    </div>
</div>
