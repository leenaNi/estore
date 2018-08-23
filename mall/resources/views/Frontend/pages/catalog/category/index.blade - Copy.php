@extends('Frontend.layouts.default')
@section('content')






@foreach($prods as $prd)


<span> 
<a href="{{ route('prod', [$prd->url_key])  }}" >
    
   
    {!! Html::image($prd->prodImage, 'a picture', array('height' => '200','width' => '200')) !!}
    
    {{$prd->product}}
</a></span>

@endforeach




@stop