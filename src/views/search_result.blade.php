@extends(config('location.layout'))
@section(config('location.content_section'))
        @include('vendor.langs.includes.tools')
        <h2 class="text-center">{{__('Buscar resultado para')}} '{{$search_value }}'</h2>
        @if (count($result) > 0)
            <div class="col-xs-12">
                @foreach ($result as $element)
                    <div class="row">
                        <div class="col-xs-6">
                            {{$element->en}} <br>
                        </div>
                        <div class="col-xs-6 text-center">
                            <a href="{{route('amamarul.translations.lang.string',$element->code)}}" class="btn btn-xs btn-warning">{{__('Mostrar')}}</a>
                        </div>
                        <hr>
                    </div>
                @endforeach
            </div>
            @else
                <div class="col-xs-12">
                    <h3>{{__('No hay resultados para')}} {{ $search_value }}</h3>
                </div>
        @endif
@endsection
