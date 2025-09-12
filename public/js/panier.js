document.addEventListener('DOMContentLoaded', function() {
    window.cart = {
        items: [],
        total: 0,
        init() {
            this.loadCart();
            this.setupEventListeners();
            console.log('Panier initialisé'); // Debug
        },
        loadCart() {
            const savedCart = localStorage.getItem('cart');
            if (savedCart) {
                const parsedCart = JSON.parse(savedCart);
                this.items = parsedCart.items || [];
                this.total = parsedCart.total || 0;
                this.updateCartUI();
            }
        },
        saveCart() {
            localStorage.setItem('cart', JSON.stringify({
                items: this.items,
                total: this.total
            }));
        },
        setupEventListeners() {
            // Ajout au panier
            document.querySelectorAll('.btn-add').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const dishItem = e.target.closest('.dish-item');
                    this.addItem(
                        dishItem.dataset.id,
                        dishItem.dataset.name,
                        parseFloat(dishItem.dataset.price),
                        e
                    );
                });
            });

            // Vider panier
            document.querySelector('.btn-clear').addEventListener('click', () => {
                this.clearCart();
            });

            // Toggle panier - version corrigée
            const cartToggle = document.querySelector('.cart-toggle');
            const cartPanel = document.querySelector('.cart-panel');

            if (cartToggle && cartPanel) {
                cartToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    e.preventDefault();
                    console.log('Clic sur le panier'); // Debug
                    cartPanel.classList.toggle('show');
                });

                // Fermer le panier quand on clique ailleurs
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.cart-container') &&
                        !e.target.closest('.cart-panel')) {
                        cartPanel.classList.remove('show');
                    }
                });
            }

            // Commander
            document.querySelector('#commande-form').addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitOrder();
            });
        },
        addItem(id, name, price, event) {
            const existingItem = this.items.find(item => item.id === id);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                this.items.push({
                    id,
                    name,
                    price,
                    quantity: 1
                });
            }

            this.total += price;
            this.saveCart();
            this.updateCartUI();

            // Animation feedback
            const btn = event.target;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-plus-circle"></i>';
            }, 1000);
        },
        removeItem(id) {
            const itemIndex = this.items.findIndex(item => item.id === id);
            if (itemIndex !== -1) {
                const item = this.items[itemIndex];
                this.total -= item.price * item.quantity;
                this.items.splice(itemIndex, 1);
                this.saveCart();
                this.updateCartUI();
            }
        },
        clearCart() {
            this.items = [];
            this.total = 0;
            this.saveCart();
            this.updateCartUI();
        },
        updateCartUI() {
            const totalItems = this.items.reduce((sum, item) => sum + item.quantity, 0);
            document.querySelector('.cart-count').textContent = totalItems;

            const cartItemsEl = document.querySelector('.cart-items');
            cartItemsEl.innerHTML = '';

            if (this.items.length === 0) {
                cartItemsEl.innerHTML = '<p style="color: rgba(255,255,255,0.5); text-align: center;">Votre panier est vide</p>';
            } else {
                this.items.forEach(item => {
                    const itemEl = document.createElement('div');
                    itemEl.className = 'cart-item';
                    itemEl.innerHTML = `
                        <div>
                            <span class="cart-item-name">${item.name}</span>
                            <span style="color: #aaa; font-size: 0.8rem; display: block;">${item.quantity} x ${item.price.toFixed(2)} DH</span>
                        </div>
                        <div>
                            <span class="cart-item-price">${(item.price * item.quantity).toFixed(2)} DH</span>
                            <button class="btn-remove" data-id="${item.id}" style="background: none; border: none; color: #ff4444; margin-left: 10px; cursor: pointer;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    cartItemsEl.appendChild(itemEl);
                });

                document.querySelectorAll('.btn-remove').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        this.removeItem(e.target.closest('button').dataset.id);
                    });
                });
            }

            document.querySelector('.total-amount').textContent = this.total.toFixed(2);
        },
        submitOrder() {
            if (this.items.length === 0) {
                alert('Votre panier est vide !');
                return;
            }
            this.showConfirmModal();
        },
        showConfirmModal() {
            document.getElementById('confirmModal').style.display = 'block';
        },
        hideConfirmModal() {
            document.getElementById('confirmModal').style.display = 'none';
        },
        confirmOrder() {
            this.hideConfirmModal();

            // Mettre à jour les champs cachés
            document.getElementById('total-input').value = this.total;
            document.getElementById('items-input').value = JSON.stringify(this.items);

            // Récupérer le formulaire
            const form = document.getElementById('commande-form');
            const formData = new FormData(form);

            // Afficher un indicateur de chargement
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Commande en cours...';
            submitBtn.disabled = true;

            // Envoyer la requête AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        this.showSuccessModal(data);
                        this.clearCart();
                    } else {
                        alert('Erreur : ' + (data.message || 'Une erreur est survenue'));
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la commande: ' + error.message);
                })
                .finally(() => {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        },
        showSuccessModal(data) {
            document.getElementById('successMessage').textContent = data.message || 'Votre commande a été passée avec succès !';
            document.getElementById('commandeId').textContent = '#' + (data.commande_id || '000');
            document.getElementById('commandeTotal').textContent = (data.total || this.total).toFixed(2) + ' DH';
            document.getElementById('successModal').style.display = 'block';
        }
    };

    // Initialisation
    window.cart.init();
});
