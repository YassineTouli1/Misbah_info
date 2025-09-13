<?php
use Illuminate\Support\Facades\Route;

// Health check routes for Railway
Route::get('/health', fn() => response()->json(['status' => 'ok']));


//les conroleurs actions
use App\Http\Controllers\Manager\MenuItemController\StoreMenuItemController;
use App\Http\Controllers\Manager\MenuItemController\IndexMenuItemController;
use App\Http\Controllers\Manager\MenuItemController\AddMenuItemController;
use App\Http\Controllers\Manager\MenuItemController\DeleteMenuItemController;
use App\Http\Controllers\Manager\MenuItemController\EditMenuItemController;
use App\Http\Controllers\Manager\MenuItemController\UpdateMenuItemController;
use App\Http\Controllers\Manager\ClientController\IndexClientController;
use App\Http\Controllers\Manager\ClientController\DeleteClientController;
use App\Http\Controllers\Manager\ClientController\AddClientController;
use App\Http\Controllers\Auth\Register\CreateRegistreController;
use App\Http\Controllers\Auth\Register\StoreRegistreController;
use App\Http\Controllers\Auth\Login\CreateLoginController;
use App\Http\Controllers\Auth\Login\StoreLoginController;
use App\Http\Controllers\Auth\Login\LogoutController;
use App\Http\Controllers\Manager\StockController\IndexStockController;
use App\Http\Controllers\Manager\StockController\StoreStockClient;
use App\Http\Controllers\Manager\StockController\EditStockController;
use App\Http\Controllers\Manager\StockController\UpdateStockController;
use App\Http\Controllers\Manager\StockController\DeleteStockController;
use App\Http\Controllers\Manager\StockController\AddStockController;
use App\Http\Controllers\Manager\MenuController\IndexMenuController;
use App\Http\Controllers\Client\ClientHomeController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\MenuController\AddMenuController;
use App\Http\Controllers\Manager\MenuController\StoreMenuController;
use App\Http\Controllers\Manager\MenuController\EditMenuController;
use App\Http\Controllers\Manager\MenuController\UpdateMenuController;
use App\Http\Controllers\Manager\MenuController\DeleteMenuController;
use App\Http\Controllers\Manager\CaisseController\IndexCaisseController;
use App\Http\Controllers\Manager\CaisseController\AjouterALaCaisseController;
use App\Http\Controllers\Manager\CaisseController\AddCaisseController;
use App\Http\Controllers\Manager\CaisseController\TirerDeLaCaisseController;
use App\Http\Controllers\Manager\CaisseController\TirerCaisseController;
use App\Http\Controllers\Auth\ForgotPasswordController\IndexForgotPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController\SendResetLinkEmailController;
use App\Http\Controllers\Auth\ForgotPasswordController\IndexResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController\ResetPasswordController;
use App\Http\Controllers\Manager\SettingController\EditSettingController;
use App\Http\Controllers\Manager\SettingController\UpdateSettingController;
use App\Http\Controllers\Client\MenusController\IndexMenusController;
use App\Http\Controllers\Client\CommandeController\StoreCommandeController;
use App\Http\Controllers\Manager\CommandeController\IndexCommandeController;
use App\Http\Controllers\Manager\CommandeController\ConfirmerCommandeController;
use App\Http\Controllers\Manager\CommandeController\EnPreparationCommandeController;
use App\Http\Controllers\Manager\CommandeController\PreteCommandeController;
use App\Http\Controllers\Manager\CommandeController\LivrerCommandeController;
use App\Http\Controllers\Manager\CommandeController\AnnulerCommandeController;
use App\Http\Controllers\Manager\CommandeController\RetournerCommandeController;
use App\Http\Controllers\Client\ReviewController\AddReviewClient;
use App\Http\Controllers\Client\ReviewController\StoreReviewClient;
use App\Http\Controllers\HomeController\HomeController;
use App\Http\Controllers\TestAuthController;
use App\Http\Controllers\TestLoginController;
use App\Http\Controllers\Manager\CategoryController\IndexCategoryController;
use App\Http\Controllers\Manager\CategoryController\CreateCategoryController;
use App\Http\Controllers\Client\CommandeController;
use App\Http\Controllers\Manager\OrderController;
use App\Http\Controllers\Manager\CategoryController\StoreCategoryController;
use App\Http\Controllers\Manager\CategoryController\EditCategoryController;
use App\Http\Controllers\Manager\CategoryController\UpdateCategoryController;
use App\Http\Controllers\Manager\CategoryController\DeleteCategoryController;
use App\Http\Controllers\Manager\RuptureStockController\IndexRuptureStockController;
use App\Http\Controllers\Client\ReviewController\IndexReviewClientController;
use App\Http\Controllers\Client\ReviewController\AddReviewClientController;
use App\Http\Controllers\Client\ReviewController\EditReviewClientController;
use App\Http\Controllers\Client\ReviewController\DeleteReviewClientController;
use App\Http\Controllers\Client\ReviewController\UpdateReviewClientController;
use Illuminate\Support\Facades\Auth;
// Routes pour la gestion des catégories


Route::prefix('categories')->name('category.')->group(function () {
    Route::get('/categorie_index', IndexCategoryController::class)->name('index');
    Route::get('/categorie_create', CreateCategoryController::class)->name('create');
    Route::post('categorie_store/', StoreCategoryController::class)->name('store');
    Route::get('/{category}/edit', EditCategoryController::class)->name('edit');
    Route::put('/{category}', UpdateCategoryController::class)->name('update');
    Route::delete('/{category}', DeleteCategoryController::class)->name('destroy');
});

//tableau de bord
Route::get('main_dashboard', DashboardController::class)->name('dashboard.main');
//home
Route::get('/', HomeController::class)->name('home');
//le controleur pour le dashboard d'un gerant
Route::get('/dashboard',DashboardController::class)->name('dashboard')->middleware(['auth', 'role:gerant']);
// Routes pour les clients
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    // Tableau de bord client
    Route::get('/home', [ClientHomeController::class, 'index'])->name('home');

    // Gestion des commandes
    Route::prefix('commandes')->name('commandes.')->group(function () {
        Route::get('/', [CommandeController::class, 'index'])->name('index');
        Route::get('/creer', [CommandeController::class, 'create'])->name('create');
        Route::post('/', [CommandeController::class, 'store'])->name('store');
        Route::get('/{commande}', [CommandeController::class, 'show'])->name('show');
        Route::patch('/{commande}/annuler', [CommandeController::class, 'annuler'])->name('annuler');
        Route::patch('/{commande}/valider', [CommandeController::class, 'valider'])->name('valider'); // <-- Ajout de la route valider
    });

    // Autres routes client...
    Route::get('/review/add', AddReviewClientController::class)->name('review.add');
    Route::get('/reviews', IndexReviewClientController::class)->name('review.index');
    Route::get('/review/{review}/edit', EditReviewClientController::class)->name('review.edit');
    Route::delete('/review/{review}', DeleteReviewClientController::class)->name('review.destroy');
});
//les controleurs de Menu
Route::get('/menus', IndexMenuController::class)->name('menus');
Route::get('/addMenu', AddMenuController::class)->name('addMenu');
Route::post('/addMenu', StoreMenuController::class)->name('menu.store');
Route::get('/editMenu/{menu}',EditMenuController::class)->name('editMenu');
Route::put('/editMenu/{menu}', UpdateMenuController::class)->name('editMenu.update');
Route::delete('/deleteMenu/{menu}',DeleteMenuController::class)->name('deleteMenu');
//les controlleurs de Stock
Route::get('/stock',IndexStockController::class)->name('stock.index')->middleware('role:gerant');
Route::post('/stock',StoreStockClient::class)->name('stock.store');
Route::get('/editingredient/{ingredient_id}',EditStockController::class)->name('ingredient.edit');
Route::put('/ingredients/{ingredient_id}', UpdateStockController::class)->name('ingredient.update');
Route::delete('/ingredients/{ingredient_id}', DeleteStockController::class)->name('stock.destroy');
Route::get('addingredient',AddStockController::class);

//les controleurs  de login
Route::get('/login', CreateLoginController::class)->name('login');
Route::post('/login', StoreLoginController::class)->name('login.store');
Route::post('/logout', LogoutController::class)->name('logout');
//les controleurs de Registre
Route::get('/register', CreateRegistreController::class)->name('register');
Route::post('/register', StoreRegistreController::class)->name('register');
//les controleurs de client partie admin
Route::get('/clients',IndexClientController::class)->name('clients');
Route::delete('/clients/{client}', DeleteClientController::class)->name('clients.destroy');
Route::get('addClient',AddClientController::class)->name('clients.add');
//Les controleurs de MenuItem
Route::get('/addMenuItem', AddMenuItemController::class)->name('addMenuItem');
Route::get('/menuItems', IndexMenuItemController::class)->name('menuItems');
Route::post('/menuItems', StoreMenuItemController::class)->name('menuItem.store');
Route::delete('/destroyMenuItem/{menuItem}',DeleteMenuItemController::class)->name('menuItem.destroy');
Route::get('/editMenuItem/{menuItem}',EditMenuItemController::class)->name('editMenuItem.edit');
Route::put('/editMenuItem/{menuItem}',UpdateMenuItemController::class)->name('editMenuItem.update');
//les controleurs de la caisse
Route::get('/caisses',IndexCaisseController::class)->name('caisses');
Route::get('/manager/caisse',IndexCaisseController::class)->name('manager.caisse')->middleware('role:gerant');
Route::get('/ajoutercaisse',AjouterALaCaisseController::class)->name('caisse.pop_up_ajout')->middleware('role:gerant');
Route::post('/caisse/ajout',AddCaisseController::class)->name('caisse.ajout_caisse')->middleware('role:gerant');
Route::get('/tirercaisse',TirerDeLaCaisseController::class)->name('caisse.tirer_caisse_pop_up')->middleware('role:gerant');
Route::post('/tirercaisse', TirerCaisseController::class)->name('tirercaisse');
//les controlleurs Pour le mot de passe oublié
Route::get('mot-de-passe-oublie',IndexForgotPasswordController::class)->name('password.request');
Route::post('mot-de-passe-email',SendResetLinkEmailController::class )->name('password.email');
Route::get('reinitialiser-mot-de-passe/{token}', IndexResetPasswordController::class)->name('password.reset');
Route::post('reinitialiser-mot-de-passe', ResetPasswordController::class)->name('password.update');
//les controlleurs de setting
Route::get('/admin/settings',EditSettingController::class )->name('admin.setting.edit')->middleware('role:gerant');
Route::post('/admin/settings', UpdateSettingController::class)->name('admin.settings.update')->middleware('role:gerant');
//afficher les cmds pour l'admin
Route::get('/commandes', IndexCommandeController::class)->name('dashboard.commandes')->middleware('role:gerant');

// Routes pour les actions sur les commandes (gérant)
Route::middleware(['auth', 'role:gerant'])->prefix('commandes')->name('commandes.')->group(function () {
    Route::patch('/{commande}/confirmer', ConfirmerCommandeController::class)->name('confirmer');
    Route::patch('/{commande}/en-preparation', EnPreparationCommandeController::class)->name('en-preparation');
    Route::patch('/{commande}/prete', PreteCommandeController::class)->name('prete');
    Route::patch('/{commande}/livrer', LivrerCommandeController::class)->name('livrer');
    Route::patch('/{commande}/annuler', AnnulerCommandeController::class)->name('annuler');
    Route::patch('/{commande}/retourner', RetournerCommandeController::class)->name('retourner');
});

//les controleurs partie client
// Menus clients
Route::get('/home/menus',IndexMenusController::class )->name('client.menus');
//passer une commande par le client
Route::post("/home/commander",StoreCommandeController::class)->name('storeCmd');
//donner un review
Route::get('/client/review/',IndexReviewClientController::class)->name('client.review');
Route::post('/client/review',StoreReviewClient::class)->name('review.store');
Route::get('/client/review/{review}',EditReviewClientController::class)->name('review.edit');
Route::delete('/client/review/{review}',DeleteReviewClientController::class)->name('review.destroy');
Route::put('/client/review/{review}',UpdateReviewClientController::class)->name('review.update');
// Route de test pour l'authentification
Route::get('/test-auth', TestAuthController::class)->name('test.auth');

// Route de redirection /home selon le rôle
Route::get('/home', function() {
    if (Auth::check()) {
        if (Auth::user()->role === 'client') {
            return redirect('/client/home');
        } elseif (Auth::user()->role === 'gerant') {
            return redirect('/dashboard');
        }
    }
    return redirect('/login');
})->name('home.redirect');

// Route de test pour le dashboard sans middleware
Route::get('/test-dashboard', function() {
    return view('dashboard.dashboard', [
        'nbrClient' => \App\Models\Client::count(),
        'nbrPlat' => \App\Models\MenuItem::count()
    ]);
})->name('test.dashboard');

// Route de test pour la connexion
Route::post('/test-login', TestLoginController::class)->name('test.login');

// Page de test de connexion
Route::get('/test-login-page', function() {
    return view('test-login');
})->name('test.login.page');

// les controlleurs pour le rupture de stock
Route::get('/rupture-stock',IndexRuptureStockController::class)->name('rupture.index');

Route::get('/avis', IndexReviewClientController::class)->name('review.index');
Route::delete('/avis/{review}',DeleteReviewClientController::class)->name('review.destroy');
