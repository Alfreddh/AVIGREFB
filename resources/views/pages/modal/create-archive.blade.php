<form action="{{ route('archives.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="ArchiveCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter à l'archive</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Fields -->
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group input-group-outline mt-3">
                            <label class="form-label">Nom du document</label>
                            <input type="text" class="form-control" name="nom">
                            @error('nom')
                                <p class='text-danger inputerror'>{{ $message }}</p>
                            @enderror
                        </div>                        
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
                    <!-- Other Form Fields... -->
                    <div class="row col-xs-12 col-sm-12 col-md-12" style="margin-top: 15px;">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <span style="font-size: 0.875rem;">Zone</span>
                            <div class="input-group input-group-outline mt-1">
                                <label for="zone_id"></label>
                                <select class="form-control" id="zone_id" name="zone_id">
                                    <option value="">Select Zone</option>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->libelle }}</option>
                                    @endforeach
                                </select>
                                @error('zone_id')
                                    <p class='text-danger inputerror'>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <span style="font-size: 0.875rem;">Village</span>
                            <div class="input-group input-group-outline mt-1">
                                <label for="zone_id"></label>
                                <select class="form-control" id="village_id" name="village_id">
                                    <option value="">Selectionner le village</option>
                                    @foreach($villages as $village)
                                        <option value="{{ $village->id }}">{{ $village->libelle }}</option>
                                    @endforeach
                                </select>
                                @error('zone_id')
                                    <p class='text-danger inputerror'>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
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
                    <!-- Other Form Fields... -->
                    <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 15px;">
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#zone_id').change(function() {
            var zoneId = $(this).val();
            var _token = $('input[name="_token"]').val();

            if (zoneId) {
                $.ajax({
                    url: "{{ route('getvillages') }}",
                    type: 'GET',
                    data: {
                        zone_id: zoneId,
                        _token: _token
                    },
                    success: function(response) {  
                        $('#village_id').html(response.options);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });
            } else {
                $('#village_id').html('<option value="">Select Village</option>');
            }
        });
    });
</script>
