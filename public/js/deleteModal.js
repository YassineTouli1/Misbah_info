console.log("JS chargé");
document.addEventListener('DOMContentLoaded', function () {
    let currentResource = {
        type: null,
        id: null
    };

    const modal = document.getElementById('customModal');
    const modalMessage = document.getElementById('modalMessage');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            currentResource.type = this.getAttribute('data-resource-type');
            currentResource.id = this.getAttribute('data-resource-id');
            const resourceName = this.getAttribute('data-resource-name');

            modalMessage.textContent = `Êtes-vous sûr de vouloir supprimer cet élément ?`;
            modal.style.display = 'flex';
        });
    });

    document.getElementById('confirmDelete').addEventListener('click', function () {
        if (currentResource.id && currentResource.type) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/${currentResource.type}/${currentResource.id}`;

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = csrfToken;

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';

            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }

        modal.style.display = 'none';
    });

    document.getElementById('cancelDelete').addEventListener('click', function () {
        modal.style.display = 'none';
        currentResource = { type: null, id: null };
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            currentResource = { type: null, id: null };
        }
    });
});
