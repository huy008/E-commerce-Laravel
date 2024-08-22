<script src="http://127.0.0.1:8000/backend/js/bootstrap.min.js"></script>
<script src="http://127.0.0.1:8000/backend/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="http://127.0.0.1:8000/backend/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="http://127.0.0.1:8000/backend/library/library.js"></script>
<script src="http://127.0.0.1:8000/backend/js/inspinia.js"></script>
<script src="http://127.0.0.1:8000/backend/js/plugins/pace/pace.min.js"></script>

@if(isset($config['js']) && is_array($config['js']) )
@foreach($config['js'] as $key => $value)
{!! '<script src="'.$value.'"></script> ' !!}
@endforeach
@endif