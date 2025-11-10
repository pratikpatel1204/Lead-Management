<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DropdownController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ValidationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache cleared!";
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'loginSubmit'])->name('login.submit');
    });
    Route::middleware(['auth:admin'])->group(function () {

        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('profile', [AdminAuthController::class, 'profile'])->name('profile');
        Route::post('profile-update', [AdminAuthController::class, 'profile_update'])->name('profile.update');
        Route::middleware(['permission:View dashboard'])->group(function () {
            Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        });

        Route::middleware(['permission:Create Employee'])->group(function () {
            Route::get('create-employee', [EmployeeController::class, 'create_employee'])->name('create.employee');
            Route::post('employee-store', [EmployeeController::class, 'employee_store'])->name('employee.store');
        });
        Route::middleware(['permission:View Employee'])->group(function () {
            Route::get('employee-list', [EmployeeController::class, 'employee_list'])->name('employee.list');
        });
        Route::middleware(['permission:Edit Employee'])->group(function () {
            Route::get('employee-edit/{id}', [EmployeeController::class, 'employee_edit'])->name('employee.edit');
            Route::post('employee-update', [EmployeeController::class, 'employee_update'])->name('employee.update');
        });
        Route::middleware(['permission:Delete Employee'])->group(function () {
            Route::delete('employee-delete/{id}', [EmployeeController::class, 'employee_delete'])->name('employee.delete');
        });


        Route::middleware(['permission:View Roles'])->group(function () {
            Route::get('/roles', [RoleController::class, 'role_list'])->name('roles.list');
        });
        Route::middleware(['permission:Edit Roles'])->group(function () {
            Route::get('/roles-edit/{id}', [RoleController::class, 'role_edit'])->name('roles.edit');
            Route::post('/roles-update', [RoleController::class, 'role_update'])->name('roles.update');
        });

        Route::middleware(['permission:View Permissions'])->group(function () {
            Route::get('/permissions', [PermissionController::class, 'permissions_list'])->name('permissions.list');
        });
        Route::middleware(['permission:Create Permissions'])->group(function () {
            Route::get('/create-permissions', [PermissionController::class, 'permissions_create'])->name('permissions.create');
            Route::post('/permissions-store', [PermissionController::class, 'permissions_store'])->name('permissions.store');
        });
        Route::middleware(['permission:Edit Permissions'])->group(function () {
            Route::get('/permissions-edit/{id}', [PermissionController::class, 'permissions_edit'])->name('permissions.edit');
            Route::post('/permissions-update', [PermissionController::class, 'permissions_update'])->name('permissions.update');
        });

        Route::middleware(['permission:About Us'])->group(function () {
            Route::get('/about-us-edit', [DashboardController::class, 'about_us_edit'])->name('about.us.edit');
            Route::post('/about-us-update', [DashboardController::class, 'about_us_update'])->name('about.us.update');
        });
        Route::middleware(['permission:Contact Us'])->group(function () {
            Route::get('/contact-settings', [DashboardController::class, 'contact_settings'])->name('contact.settings');
            Route::post('/contact-settings-update', [DashboardController::class, 'contact_settings_update'])->name('contact.settings.update');
        });

        Route::middleware(['permission:Banner'])->group(function () {
            Route::get('/banners', [BannerController::class, 'banner_list'])->name('banner.list');

            Route::get('/banners-create', [BannerController::class, 'create_banner'])->name('banner.create');
            Route::post('/banners-store', [BannerController::class, 'store_banner'])->name('banner.store');

            Route::get('/banners-edit/{id}', [BannerController::class, 'edit_banner'])->name('banner.edit');
            Route::post('/banners-update', [BannerController::class, 'update_banner'])->name('banner.update');

            Route::delete('/banners-delete/{id}', [BannerController::class, 'destroy_banner'])->name('banner.delete');
        });
        Route::middleware(['permission:Testimonial'])->group(function () {
            Route::get('/testimonials', [TestimonialController::class, 'testimonials_list'])->name('testimonials.list');

            Route::get('/testimonial-create', [TestimonialController::class, 'create_testimonial'])->name('testimonial.create');
            Route::post('/testimonial-store', [TestimonialController::class, 'store_testimonial'])->name('testimonial.store');

            Route::get('/testimonial-edit/{id}', [TestimonialController::class, 'edit_testimonial'])->name('testimonial.edit');
            Route::post('/testimonial-update', [TestimonialController::class, 'update_testimonial'])->name('testimonial.update');

            Route::delete('/testimonial-delete/{id}', [TestimonialController::class, 'destroy_testimonial'])->name('testimonial.delete');
        });

        Route::middleware(['permission:Create Services Categories'])->group(function () {
            Route::get('/create-services-categories', [ServiceController::class, 'create_services_categories'])->name('create.services.categories');
            Route::post('/services-categories-store', [ServiceController::class, 'services_categories_store'])->name('services.categories.store');
        });
        Route::middleware(['permission:Services Categories List'])->group(function () {
            Route::get('/services-categories-list', [ServiceController::class, 'services_categories_list'])->name('services.categories.list');
        });
        Route::middleware(['permission:Services Categories Edit'])->group(function () {
            Route::get('/services-categories-edit/{id}', [ServiceController::class, 'services_categories_edit'])->name('services.categories.edit');
            Route::post('/services-categories-update', [ServiceController::class, 'services_categories_update'])->name('services.categories.update');
        });
        Route::middleware(['permission:Services Categories Delete'])->group(function () {
            Route::delete('/services-categories-delete/{id}', [ServiceController::class, 'services_categories_destroy'])->name('services.categories.delete');
        });

        Route::middleware(['permission:Create Service'])->group(function () {
            Route::get('/create-services', [ServiceController::class, 'create_services'])->name('create.services');
            Route::post('/services-store', [ServiceController::class, 'services_store'])->name('services.store');
        });
        Route::middleware(['permission:Service List'])->group(function () {
            Route::get('/services-list', [ServiceController::class, 'services_list'])->name('services.list');
        });
        Route::middleware(['permission:Service Edit'])->group(function () {
            Route::get('/services-edit/{id}', [ServiceController::class, 'services_edit'])->name('services.edit');
            Route::post('/services-update', [ServiceController::class, 'services_update'])->name('services.update');
        });
        Route::middleware(['permission:Service Delete'])->group(function () {
            Route::delete('/services-delete/{id}', [ServiceController::class, 'services_destroy'])->name('services.delete');
        });

        Route::middleware(['permission:Create Team'])->group(function () {
            Route::get('/create-team', [TeamController::class, 'create_team'])->name('create.team');
            Route::post('/team-store', [TeamController::class, 'team_store'])->name('team.store');
        });
        Route::middleware(['permission:Team List'])->group(function () {
            Route::get('/team-list', [TeamController::class, 'team_list'])->name('team.list');
        });
        Route::middleware(['permission:Team Edit'])->group(function () {
            Route::get('/team-edit/{id}', [TeamController::class, 'team_edit'])->name('team.edit');
            Route::post('/team-update', [TeamController::class, 'team_update'])->name('team.update');
        });
        Route::middleware(['permission:Team Delete'])->group(function () {
            Route::delete('/team-delete/{id}', [TeamController::class, 'team_destroy'])->name('team.delete');
        });

        Route::middleware(['permission:Blogs Categories'])->group(function () {
            Route::get('/blog-categories', [BlogController::class, 'blog_categories_list'])->name('blog.categories.list');

            Route::get('/blog-categories-create', [BlogController::class, 'create_blog_categories'])->name('blog.categories.create');
            Route::post('/blog-categories-store', [BlogController::class, 'store_blog_categories'])->name('blog.categories.store');

            Route::get('/blog-categories-edit/{id}', [BlogController::class, 'edit_blog_categories'])->name('blog.categories.edit');
            Route::post('/blog-categories-update', [BlogController::class, 'update_blog_categories'])->name('blog.categories.update');

            Route::delete('/blog-categories-delete/{id}', [BlogController::class, 'destroy_blog_categories'])->name('blog.categories.delete');
        });       

        Route::middleware(['permission:Create Blogs'])->group(function () {
            Route::get('/create-blog', [BlogController::class, 'create_blog'])->name('create.blog');
            Route::post('/blog-store', [BlogController::class, 'blog_store'])->name('blog.store');
        });
        Route::middleware(['permission:All Blogs'])->group(function () {
            Route::get('/blog-list', [BlogController::class, 'blog_list'])->name('blog.list');
        });
        Route::middleware(['permission:Blogs Edit'])->group(function () {
            Route::get('/blog-edit/{id}', [BlogController::class, 'blog_edit'])->name('blog.edit');
            Route::post('/blog-update', [BlogController::class, 'blog_update'])->name('blog.update');
        });
        Route::middleware(['permission:Blogs Delete'])->group(function () {
            Route::delete('/blog-delete/{id}', [BlogController::class, 'blog_destroy'])->name('blog.delete');
        });

        Route::middleware(['permission:Inquiry'])->group(function () {
            Route::get('/inquery-list', [DashboardController::class, 'inquery_list'])->name('inquery.list');
            Route::delete('/inquiry-delete/{id}', [DashboardController::class, 'inquiry_delete'])->name('inquiry.delete');
        });

        Route::middleware(['permission:Why Choose Us'])->group(function () {
            Route::get('/why-choose-us', [DashboardController::class, 'why_choose_us'])->name('why.choose.us');
            Route::post('/why-choose-us-update', [DashboardController::class, 'update_why_choose_us'])->name('why.choose.us.update');
        });

        Route::middleware(['permission:Field Master'])->group(function () {
            Route::get('/field-list', [FieldController::class, 'field_list'])->name('field.list');
            Route::get('/create-field', [FieldController::class, 'create_field'])->name('create.field');
            Route::post('/field-store', [FieldController::class, 'field_store'])->name('field.store');
            Route::get('/field-edit/{id}', [FieldController::class, 'field_edit'])->name('field.edit');
            Route::post('/field-update', [FieldController::class, 'field_update'])->name('field.update');
            Route::delete('/field-delete/{id}', [FieldController::class, 'field_delete'])->name('field.delete');
            
            Route::get('/field-type-list', [FieldController::class, 'field_type_list'])->name('field.type.list');
            Route::get('/create-field-type', [FieldController::class, 'create_field_type'])->name('create.field.type');
            Route::post('/field-type-store', [FieldController::class, 'field_type_store'])->name('field.type.store');
            Route::get('/field-type-edit/{id}', [FieldController::class, 'field_type_edit'])->name('field.type.edit');
            Route::post('/field-type-update', [FieldController::class, 'field_type_update'])->name('field.type.update');
            Route::delete('/field-type-delete/{id}', [FieldController::class, 'field_type_delete'])->name('field.type.delete');
           
            Route::get('/validation-list', [ValidationController::class, 'validation_list'])->name('validation.list');
            Route::get('/create-validation', [ValidationController::class, 'create_validation'])->name('create.validation');
            Route::post('/validation-store', [ValidationController::class, 'validation_store'])->name('validation.store');
            Route::get('/validation-edit/{id}', [ValidationController::class, 'validation_edit'])->name('validation.edit');
            Route::post('/validation-update', [ValidationController::class, 'validation_update'])->name('validation.update');
            Route::delete('/validation-delete/{id}', [ValidationController::class, 'validation_delete'])->name('validation.delete');
            
            Route::get('/dropdown-list', [DropdownController::class, 'dropdown_list'])->name('dropdown.list');
            Route::get('/create-dropdown', [DropdownController::class, 'create_dropdown'])->name('create.dropdown');
            Route::post('/dropdown-store', [DropdownController::class, 'dropdown_store'])->name('dropdown.store');
            Route::get('/dropdown-edit/{id}', [DropdownController::class, 'dropdown_edit'])->name('dropdown.edit');
            Route::post('/dropdown-update', [DropdownController::class, 'dropdown_update'])->name('dropdown.update');
            Route::delete('/dropdown-delete/{id}', [DropdownController::class, 'dropdown_delete'])->name('dropdown.delete');
        });
    });
});



Route::get('/', [HomeController::class, 'index'])->name('front.index');
Route::get('/about-us', [HomeController::class, 'about_us'])->name('front.about');
Route::get('/our-service', [HomeController::class, 'services'])->name('front.services');
Route::get('/service-details/{title}', [HomeController::class, 'serviceDetails'])->name('front.service.details');
Route::get('/services-category/{slug}', [HomeController::class, 'serviceByCategory'])->name('front.service.category');
Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('front.contact');
Route::get('/our-team', [HomeController::class, 'our_team'])->name('front.our.team');
Route::get('/blog', [HomeController::class, 'blog'])->name('front.blog');
Route::get('/blog/category/{name}', [HomeController::class, 'blogByCategory'])->name('front.blog.category');
Route::get('/blog-details/{slug}', [HomeController::class, 'blogDetails'])->name('front.blog.details');

Route::post('/contact-submit', [HomeController::class, 'contactSubmit'])->name('front.contact.submit');
Route::post('/contact-inquery', [HomeController::class, 'contact_inquery'])->name('front.contact.inquery');
Route::post('/newsletter-submit', [HomeController::class, 'newsletter_submit'])->name('front.newsletter.submit');
