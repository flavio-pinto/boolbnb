@extends('layouts.app')

@section('content')

    {{-- Errori --}}
    @if (session('message'))
        <div class="alert u-alert-success">
            <p>Messaggio <span class="u-text-success">"{{ session('message') }}"</span> Inviato</p>
        </div>
    @endif
    <main class="home">

        {{-- Jumbotron --}}
        <section class="jumbo d-flex flex-wrap justify-content-center align-content-center">
            <div class="jumbo__title col-12 text-center">
                <label class="h1 d-block" for="city">TROVA LA TUA CASA</label>
            </div>
            <div class="jumbo__search col-6 d-flex align-content-center">
                <input class="search__input d-inline" type="text" name="city" id="city" placeholder="Ricerca il tuo appartamento">
                <div class="search__btn btn">CERCA</div>
            </div>

            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="long" id="long">
            <input type="hidden" name="algoName" id="algoName" value="{{ $algoName }}">
            <input type="hidden" name="algoKey" id="algoKey" value="{{ $algoKey }}">
        </section>
        {{-- Places Sponsored container --}}
        <section class="container sponsored">
            <h2 class="sponsored__title">Esclusive</h2>
            <div class="row d-flex justify-content-center">
                @foreach ($placesSponsored as $placeSponsored)
                <a class="sponsor-card col-md-5 col-lg-3 mx-2 mb-4" href="{{ route('place.show',$placeSponsored->slug) }}">
                    <img class="card__img" src="{{asset('storage/' . $placeSponsored->place_img)}}" alt="{{$placeSponsored->title}}">
                    <div class="img__wrapper"></div>
                    <div class="card__info">
                        <h5 class="card__price">€{{$placeSponsored->price}}</h5>
                        <h5 class="card__address mb-2">{{$placeSponsored->address}}</h5>
                        <div class="info__footer d-flex justify-content-between align-items-top">
                            <h5 class="card__city">{{$placeSponsored->city}}</h5>
                            <div class="card__amenities d-flex">
                                <h5><i class="fas fa-couch"></i>{{$placeSponsored->num_rooms}}</h5>
                                <h5><i class="fas fa-bed"></i>{{$placeSponsored->num_beds}}</h5>
                                <h5 class="mr-1"><i class="fas fa-toilet"></i>{{$placeSponsored->num_baths}}</h5>
                            </div>
                        </div>
                    </div>  
                </a>
                @endforeach
            </div>
        </section>

        {{-- Search Section --}}
        <section class="search">
            <div class="search_container d-flex flex-wrap align-items-center justify-content-center container">
                <div class="row w-100">
                    <div class="search__sidebar py-3">
                        <h5 class="sidebar__title text-center mt-3">Filtra i tuoi risultati</h5>
                        <div class="search__item-box d-flex justify-content-center container-fluid">
                            <div class="row">
                                <div class="sidebar__item d-flex flex-column align-items-center flex-wrap justify-content-center col-lg-6 mt-2">
                                    <label class="d-block" for="num_rooms"><i class="fas fa-couch pr-2"></i>Stanze</label>
                                    <input class="text-center" type="number" name="num_rooms" id="num_rooms" value="{{old('num_rooms',1)}}" min="0">
                                </div>          
                                <div class="sidebar__item d-flex flex-column align-items-center flex-wrap justify-content-center col-lg-6 mt-2">
                                    <label class="d-block" for="num_beds"><i class="fas fa-bed pr-2"></i>Letti</label>
                                    <input class="text-center" type="number" name="num_beds" id="num_beds" value="{{old('num_beds',1)}}" min="0">
                                </div>
                            </div>

                        </div>
                       
                        <div class="amenities container mt-5 d-flex flex-column align-items-center">
                            <h5 class="amenities__title text-center">Seleziona i servizi aggiuntivi</h5>
                            <div class="amenties__list mt-2">
                                @foreach ($amenities as $amenity)
                                    <div class="form-check d-flex">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" id="amenity-{{$loop->iteration}}" value="{{$amenity->id}}">
                                        <label class="form-check-label" for="amenity-{{$loop->iteration}}">{{$amenity->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <form class="d-flex flex-column align-items-center w-100 mt-4">
                            <input type="range" class="custom-range w-100" min="1" max="100" value="20" step="1" id="amountRange" name="amountRange" oninput="this.form.amountInput.value=this.value">

                            <span>Km</span>
                            <input type="text" name="amountInput" min="1" max="100" value="20" class="range-value text-center" oninput="this.form.amountRange.value=this.value" />
                            
                        </form>

                            <div class="search__btn btn mt-3 w-75  d-flex justify-content-center">CERCA</div>
                        </div>
                        
                    </div>
                    <div class="search__content">
                        <div class="container cards mt-3">
                            <div id="place-container" class="row d-flex justify-content-center"></div>
                        </div>  
                    </div>
                </div>

            </div>
        </section>

        {{-- Banner Section --}}
        <section class="banner">
            <div class="container">
                <div class="row d-flex justify-content-between align-items-center p-5">

                    <div class="bannner-search col-lg-3 text-center">
                        <div class="bannner-search__img">
                            <img class="wall" src="{{ asset('images/search.svg') }}" alt="search">
                        </div>
                        <div class="banner-search__text">
                            <h4>Ricerca rapida e smart</h4>
                            <p>Cerca fra centinaia di alloggi nella tua città di destinazione. Salva i tuoi preferiti e crea una notifica di ricerca così da non perdere la casa dei tuoi sogni!</p>
                        </div>
                    </div>

                    <div class="bannner-chat col-lg-3 text-center">
                        <div class="bannner-chat__img">
                            <img class="wall" src="{{ asset('images/chat.svg') }}" alt="chat">
                        </div>
                        <div class="banner-chat__text">
                            <h4>Chatta in tempo reale con gli inserzionisti</h4>
                            <p>Comunica direttamente con gli inserzionisti verificati. Uno di loro diventerà presto il tuo nuovo padrone di casa!</p>
                        </div>
                    </div>

                    <div class="bannner-buy col-lg-3 text-center">
                        <div class="bannner-buy__img">
                            <img class="wall" src="{{ asset('images/buy.svg') }}" alt="buy">
                        </div>
                        <div class="banner-buy__text">
                            <h4>Prenota e paga l'affitto online in tutta sicurezza</h4>
                            <p>Una volta pagata la prima mensilità di affitto, la casa è tua. Proteggiamo il tuo denaro e lo trasferiamo al proprietario solo 48 ore dopo che ti sei trasferito.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </section>


        {{-- Handlebars Template --}}
        <script id="places-template" type="text/x-handlebars-template">
            <a class="card col-lg-4 col-md-10 mx-2 mb-4" href="http://127.0.0.1:8000/place/@{{slug}}">
                <img class="card__img" src="http://127.0.0.1:8000/storage/@{{place_img}}" alt="@{{title}}">
                <div class="img__wrapper"></div>
                <div class="card__info">
                    <h5 class="card__price">€@{{price}}</h5>
                    <h5 class="card__address mb-2">@{{address}}</h5>
                    <div class="info__footer d-flex justify-content-between align-items-top">
                        <h5 class="card__city">@{{city}}</h5>
                        <div class="card__amenities d-flex">
                            <h5><i class="fas fa-couch"></i>@{{num_rooms}}</h5>
                            <h5><i class="fas fa-bed"></i>@{{num_beds}}</h5>
                            <h5 class="mr-1"><i class="fas fa-toilet"></i>@{{num_baths}}</h5>
                        </div>
                    </div>
                </div>  
            </a>
        </script>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/algoliasearch@4/dist/algoliasearch.umd.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=Promise%2CObject.entries%2CObject.assign"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.js'></script>
    <script src="{{ asset('js/searchHome.js') }}"></script>
    <script src="{{ asset('js/filtersearch.js') }}"></script>
@endsection




