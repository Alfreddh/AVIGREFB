<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="rapports"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="Rapports"></x-navbars.navs.auth>
            <!-- End Navbar -->
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Les rapports</h6>
                                </div>
                            </div>
                            <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" data-toggle="modal" data-target="#ProjetCreate"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Nouveau rapport</a>
                        </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    @if($rapports->isEmpty())
                                    <div class="d-flex justify-content-center align-items-center" style="height: 55vh;">
                                        <p>Aucun rapport disponible pour le moment.</p>
                                    </div>
                                    @else
                                    <table class="table align-items-center justify-content-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Projet</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Budget</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Partenaires</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Evolution</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($rapports as $id => $projetGroup)
                                            @foreach($projetGroup as $projet)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2">
                                                    @if($projet->image_path)
                                                        <img src="{{ asset('storage/' . $projet->image_path) }}" class="avatar avatar-sm rounded-circle me-2" alt="{{ $projet->nom }}">
                                                    @else
                                                        <img src="https://via.placeholder.com/2" class="avatar avatar-sm rounded-circle me-2" alt="Image non disponible">
                                                    @endif
                                                    <a href="{{ route('rapports.show', $projet->id) }}">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm">{{ $projet->nom }}</h6>
                                                        </div>
                                                    </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $projet->budget }}</p>
                                                </td>
                                                <td>
                                                <div class="avatar-group mt-2">
                                                    @php
                                                        $partenaires = $projetGroup->filter(function($item) {
                                                            return !is_null($item->partenaire_name);
                                                        });
                                                    @endphp
                                                        @if($partenaires->isEmpty())
                                                            <p class="text-sm font-weight-bold mb-0">Aucun partenaire associé.</p>
                                                        @else
                                                        <ul>
                                                            @foreach($partenaires as $partenaire)
                                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                title="{{ $partenaire->partenaire_name }}">
                                                                <img src="{{ asset('assets') }}/img/team-1.jpg" alt="{{ $partenaire->partenaire_name }}">
                                                            </a>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <span class="me-2 text-xs font-weight-bold">{{ $projet->pourcentage }}%</span>
                                                        <div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-gradient-info"
                                                                    role="progressbar" aria-valuenow="{{ $projet->pourcentage }}"
                                                                    aria-valuemin="0" aria-valuemax="100"
                                                                    style="width: {{ $projet->pourcentage }}%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                <a rel="tooltip" class="btn btn-success btn-link"
                                                    href="" data-original-title=""
                                                    title="">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                                
                                                <button type="button" class="btn btn-danger btn-link"
                                                data-original-title="" title="">
                                                <i class="material-icons">close</i>
                                                <div class="ripple-container"></div>
                                            </button>
                                            </td>
                                            </tr>
                                        @endforeach
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        <x-plugins></x-plugins>
    
</x-layout>

