<div class="modal fade" id="UserCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter un nouvel utilisateur</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Nom de l'utilisateur</label>
                                            <input type="text" class="form-control" name="name" value=''>
                                        </div>
                                        @error('password')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Email de l'utilisateur</label>
                                            <input type="text" class="form-control" name="email" value=''>
                                        </div>
                                        @error('nom')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <br>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <span style="font-size: 0.875rem;">Rôle de l'utilisateur</span>
                                        <div class="input-group input-group-outline mt-1">
                                            <label class="form-label"></label>
                                            <select class="form-control" name="type">
                                                <option value="Membre">Membre</option>
                                                <option value="Partenaire">Partenaire</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-success">Enregistrer</button>
                                    </div>
                                </form>
        </div>
    </div>
</div>