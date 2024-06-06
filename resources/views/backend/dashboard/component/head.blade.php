<meta charset="utf-8">
<meta
     name="viewport"
     content="width=device-width, initial-scale=1.0"
>
<meta
     name="csrf-token"
     content="{{ csrf_token() }}"
>
<title>INSPINIA | Dashboard v.2</title>

<link
     href=" {{ asset('ecommerce/ecommerce/public/backend/css/bootstrap.min.css')}}"
     rel="stylesheet"
>
<link
     href="{{ asset('ecommerce/ecommerce/public/backend/font-awesome/css/font-awesome.css')}}"
     rel="stylesheet"
>

<link
     href="{{ asset('ecommerce/ecommerce/public/backend/css/animate.css')}}"
     rel="stylesheet"
>
@if(isset($config[' css']) && is_array($config['css']) ) @foreach($config['css'] as $key=> $value)
{!! '
<link
     href="'.$value.'"
     rel="stylesheet"
>' !!}
@endforeach
@endif
<link
     href="{{ asset('ecommerce/ecommerce/public/backend/css/style.css')}}"
     rel="stylesheet"
>
<link
     href="{{ asset('ecommerce/ecommerce/public/backend/css/plugins/switchery/switchery.css')}}"
     rel="stylesheet"
>
<script src="{{ asset('ecommerce/ecommerce/public/backend/js/jquery-3.1.1.min.js')}}"></script>