<div class="modal fade" id="ActiviteCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter une nouvelle activité</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('projets.activites.store', $projet[0]->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Nom de l'activité</label>
                                            <input type="text" class="form-control" name="nom" value=''>
                                        </div>
                                        @error('password')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Description de l'activité</label>
                                            <input type="text" class="form-control" name="description" value=''>
                                        </div>
                                        @error('nom')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    
                                    
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Date de début estimée</label>
                                            <input type="date" class="form-control" name="date_debut_estime">
                                        </div>
                                        @error('date_debut')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Date de fin estimée</label>
                                            <input type="date" class="form-control" name="date_fin_estime">
                                        </div>
                                        @error('date_fin_estime')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-success">Enregistrer</button>
                                    </div>
                                </form>
        </div>
    </div>
</div>