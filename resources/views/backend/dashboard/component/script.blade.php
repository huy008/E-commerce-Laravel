<script src="{{ asset('ecommerce/ecommerce/public/backend/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('ecommerce/ecommerce/public/backend/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{ asset('ecommerce/ecommerce/public/backend/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{ asset('ecommerce/ecommerce/public/backend/library/library.js')}}"></script>
<script src="{{ asset('ecommerce/ecommerce/public/backend/js/inspinia.js')}}"></script>
<script src="{{ asset('ecommerce/ecommerce/public/backend/js/plugins/pace/pace.min.js')}}"></script>

@if(isset($config['js']) && is_array($config['js']) )
@foreach($config['js'] as $key => $value)
{!! '<script src="'.$value.'"></script> ' !!}
@endforeach
@endif

