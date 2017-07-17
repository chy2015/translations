<div class="row">
    <a href="{{route('amamarul.translations.lang.publishAll')}}" class="btn btn-default pull-left">{{__('Publicar todos los archivos')}}</a>
    <a href="{{route('amamarul.translations.home')}}" class="btn btn-default pull-right">{{__('Todos Los Idiomas')}}</a>
    <hr>
    <div class="col-xs-6 pull-right">
        <form action="{{route('amamarul.translations.lang.newLang')}}" class="form-horizontal" method="GET" onSubmit="if(!confirm('{{__('¿Estás seguro de que quieres crear un nuevo literal?')}}')){return false;}">
            <div class="col-xs-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="newLang" id="new-lang" placeholder="{{__('Codigo Idioma Ej. es_ES')}}">
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <input type="submit" class='btn btn-primary btn-block' value="New Language">
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-6 pull-left">
        <form action="{{route('amamarul.translations.lang.newString')}}" class="form-horizontal" method="GET" onSubmit="if(!confirm('{{__('¿Estás seguro de que quieres crear un nuevo Idioma?')}}')){return false;}">
            <div class="col-xs-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="newString" id="new-string" placeholder=" {{__("Ej. Hola")}}">
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <input type="submit" class='btn btn-primary btn-block' value="{{__('Nuevo  Literal')}}">
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-12 pull-left">
        <form action="{{route('amamarul.translations.lang.search')}}" class="form-horizontal" method="GET">
            <div class="col-xs-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="search" id="new-search" placeholder="{{__('Busqueda')}}">
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <input type="submit" class='btn btn-success btn-block' value="{{__('Busqueda')}}">
                </div>
            </div>
        </form>
    </div>
</div>
