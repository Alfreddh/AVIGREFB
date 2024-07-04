<form action="{{route('projets.store')}}" method="post" enctype="multipart/form-data">
    <div class="modal fade text-left" id="ProjetCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Créer un nouveau projet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group input-group-outline mt-3">
                            <label class="form-label">Nom du projet</label>
                            <input type="text" class="form-control" name="nom" value=''>
                        </div>
                        @error('password')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group input-group-outline mt-3">
                            <label class="form-label"></label>
                            <textarea class="form-control" name="description" rows="5" placeholder="Description du projet"></textarea>
                        </div>
                        @error('nom')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group input-group-outline mt-3">
                            <label class="form-label">Budget du projet</label>
                            <input type="text" class="form-control" name="budget" value=''>
                        </div>
                        @error('nom')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    <span style="font-size: 0.875rem;">Partenaire</span>
                    <div class="input-group input-group-outline mt-1">
                        <label for="partenaire"></label>
                        <select name="partenaire" id="partenaire" class="form-control">
                            <option value="">Sélectionnez un partenaire</option>
                            @foreach($partnaires as $partnaire)
                                <option value="{{ $partnaire->id }}">{{ $partnaire->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="row col-xs-12 col-sm-12 col-md-12" style="margin-top: 15px;">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <span style="font-size: 0.875rem;">Choisir l'image du projet</span>
                            <div class="input-group input-group-outline mt-1">
                                <label for="image" class="form-label"></label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            @error('nom')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <span style="font-size: 0.875rem;">Ajouter le rapport du projet(PDF)</span>
                            <div class="input-group input-group-outline mt-1">
                                <label for="rapport" class="form-label"></label>
                                <input type="file" class="form-control" name="rapport">
                            </div>
                            @error('nom')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row col-xs-12 col-sm-12 col-md-12" style="margin-top: 15px;">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <span style="font-size: 0.875rem;">Date de début estimé</span>
                            <div class="input-group input-group-outline mt-1">
                                <label class="form-label"></label>
                                <input type="date" class="form-control" name="datedeb" value=''>
                            </div>
                            @error('datedeb')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <span style="font-size: 0.875rem;">
                                Date de fin estimé
                            </span>
                            <div class="input-group input-group-outline mt-1">
                                <label class="form-label"></label>
                                <input type="date" class="form-control" name="datefin" value=''>
                            </div>
                            @error('datefin')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                    </div>


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