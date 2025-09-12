<div class="modal-header">
    <h5 class="modal-title" id="ajouterMontantLabel">
        <i class="fas fa-plus-circle text-success"></i> Ajouter de l'argent
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form method="POST" action="{{ route('caisse.ajout_caisse') }}">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label for="montant" class="form-label">Montant à ajouter (DH)</label>
            <input type="number" 
                   class="form-control" 
                   id="montant" 
                   name="montant" 
                   placeholder="Entrez le montant" 
                   min="0" 
                   step="0.01" 
                   required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-plus"></i> Ajouter
        </button>
    </div>
</form>
