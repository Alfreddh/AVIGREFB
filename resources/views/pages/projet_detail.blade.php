<!-- resources/views/projets/show.blade.php -->
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Tables"></x-navbars.navs.auth>
        <div class="container">
            <h1>Projet : {{ $projet[0]->nom }}</h1>
            <p>{{ $projet[0]->description }}</p>

            <h2>Activités</h2>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ActiviteCreate">Ajouter une activité</a>
            <ul class="list-group mt-3">
                @foreach($activites as $activite)
                    <li class="list-group-item">
                        <h3>{{ $activite->nom }}</h3>
                        <p>{{ $activite->description }}</p>
                        <p>Status : {{ $activite->status }}</p>
                        @if($activite->rapport)
                            <p>Rapport : <a href="{{ Storage::url($activite->rapport) }}" target="_blank">Voir le rapport</a></p>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#changerRapportModal{{ $activite->id }}">Changer de rapport</button>
                        @endif
                        @if($activite->status == 'Non debutée')
                            <form action="{{ route('projets.activites.commencer', [$projet[0]->id, $activite->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Commencer</button>
                            </form>
                        @endif
                        @if($activite->status == 'En cours')
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#terminerActiviteModal{{ $activite->id }}">Terminer</button>
                        @endif
                        <form action="{{ route('projets.activites.destroy', [$projet[0]->id, $activite->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </li>

                    <!-- Modal pour terminer l'activité -->
                    <div class="modal fade" id="terminerActiviteModal{{ $activite->id }}" tabindex="-1" role="dialog" aria-labelledby="terminerActiviteModalLabel{{ $activite->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="terminerActiviteModalLabel{{ $activite->id }}">Terminer l'activité : {{ $activite->nom }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('projets.activites.terminer', [$projet[0]->id, $activite->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="rapport">Télécharger le rapport (PDF)</label>
                                            <input type="file" class="form-control" name="rapport" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary">Terminer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal pour changer de rapport -->
                    <div class="modal fade" id="changerRapportModal{{ $activite->id }}" tabindex="-1" role="dialog" aria-labelledby="changerRapportModalLabel{{ $activite->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changerRapportModalLabel{{ $activite->id }}">Changer le rapport de l'activité : {{ $activite->nom }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('projets.activites.changerRapport', [$projet[0]->id, $activite->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nouveau_rapport">Télécharger le nouveau rapport (PDF)</label>
                                            <input type="file" class="form-control" name="nouveau_rapport" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary">Changer de rapport</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @endforeach
            </ul>
            <x-footers.auth></x-footers.auth>
        </div>
        @include('pages.modal.create-activite')
        <x-plugins></x-plugins>
    </main>
</x-layout>
