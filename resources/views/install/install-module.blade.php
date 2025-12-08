@extends('layouts.install')
@section('title', 'Installation/Update')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <br/><br/>
            <div class="box box-primary active">
                <div class="box-body">

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {!! session('error') !!}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                          <ul>
                          @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                          </ul>
                        </div>
                    @endif

                    <form class="form" id="details_form" method="post" action="{{ $action_url }}">
                        {{ csrf_field() }}

                        <h2>
                            Install Module
                            <br/>
                            <small class="text-muted">
                                No license required for this installation
                            </small>
                        </h2>
                        <hr/>

                        {{-- ✅ Hidden license fields (bypass) --}}
                        <input type="hidden" name="license_code" value="FREE">
                        <input type="hidden" name="login_username" value="LOCAL">
                        <input type="hidden" name="ENVATO_EMAIL" value="local@localhost">

                        {{-- ✅ Optional info display (not required) --}}
                        <div class="alert alert-info">
                            <strong>Note:</strong> License validation is disabled.
                            This module will install directly.
                        </div>

                        <div class="col-md-12">
                            <button type="submit"
                                id="install_button"
                                class="btn btn-primary pull-right">
                                Install Module
                            </button>
                        </div>

                        <div class="clearfix"></div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
    $('form#details_form').submit(function(){
        $('#install_button')
            .attr('disabled', true)
            .text('Installing...');
    });
});
</script>
@endsection
