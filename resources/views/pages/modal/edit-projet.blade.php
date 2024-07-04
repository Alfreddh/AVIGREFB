<form action="{{ route('projets.update', $projet->id) }}" method="post" enctype="multipart/form-data">
    <div class="modal fade text-left" id="ProjetEdit{{ $projet->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modifier le projet {{ $projet->nom }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group input-group-outline mt-3">
                            <label class="form-label">Nom du projet</label>
                            <input id="nom" type="text" class="form-control" name="nom" value=''>
                        </div>
                        @error('password')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group input-group-outline mt-3">
                            <label class="form-label">Description du projet</label>
                            <textarea id="description" class="form-control" name="description" rows="5" placeholder="Description du projet"></textarea>
                        </div>
                        @error('description')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                        @enderror
                    </div>

                    <!-- Ajoutez les autres champs ici -->

                    <br>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <a href="{{ route('projets')}}" class="btn grey btn-outline-secondary">Retour</a>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>