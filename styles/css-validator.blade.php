:root {
@foreach($css as $key => $value)
    {{$key}}:{{$value}};
@endforeach
}