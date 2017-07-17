@extends(config('location.layout'))

@section(config('location.content_section'))
        @include('vendor.langs.includes.tools')
        <h2 class="text-center">{{__('Idiomas Instalados')}}</h2>

        @foreach ($langs as $lang)
            <div class="col-sm-4 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">{{__('Idioma')}} <b>{{ucfirst($lang)}}</b></div>
                    <div class="panel-body">
                        <a href="{{route('amamarul.translations.lang',$lang)}}" class="btn btn-success btn-block">{{ __('Editar') }} {{ucfirst($lang)}}</a> <br><br>
                        <a href="{{route('amamarul.translations.lang.generateJson',$lang)}}" class="btn btn-primary btn-block">{{__('Generar Archivo de Idioma')}}</a>
                    </div>
                </div>
            </div>
        @endforeach

@endsection
