public function boot(): void
{
    parent::boot();

    // Tambahkan ini untuk register controller
    $this->routes(function () {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    });
}