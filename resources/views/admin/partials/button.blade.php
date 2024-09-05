@php
    //This function will take the route name and return the access permission.
    if(!isset($routeName) || $routeName == '' || $routeName == null){
        $check = false;
    }else{
        $check = true;
    }
    //Parameters
    $parameterArray = isset($params) ? $params: [];
@endphp
@if ($check)
    <a href="{{ route($routeName,$parameterArray) }}" class="btn btn-sm {{$className}}">{{ __($label) }}</a>
@endif