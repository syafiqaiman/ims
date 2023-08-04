
// Invoice
Route::get('invoice/{id}/download', [InvoiceController::class, 'download'])->name('invoice.download');

// Floor
Route::get('/floors', [FloorController::class, 'index'])->name('floor.index'); 

// PDF Report Monthly
Route::get('/monthly-report', [PDFReportController::class, 'index'])->name('report.index');

// Product Report Monthly
Route::get('/product-report/{id}', [ProductReportController::class, 'index'])->name('product-report.index');

// Weekly Report for admin
Route::get('/weekly-report', [PDFReportController::class, 'showWeeklyReport'])->name('showWeeklyReport');
Route::get('/admin/generate-weekly-report', [PDFReportController::class, 'generateWeeklyReports'])->name('generateWeeklyReports');