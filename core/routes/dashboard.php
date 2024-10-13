<?php

use App\Http\Controllers\Admin\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Dashboard\MenusController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\EventsController;
use App\Http\Controllers\Dashboard\TopicsController;
use App\Http\Controllers\Dashboard\BannersController;
use App\Http\Controllers\Admin\TypeActivityController;
use App\Http\Controllers\Dashboard\ContactsController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\WebmailsController;
use App\Http\Controllers\Dashboard\AnalyticsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\FileManagerController;
use App\Http\Controllers\Dashboard\WebmasterBannersController;
use App\Http\Controllers\Dashboard\WebmasterLicenseController;
use App\Http\Controllers\Dashboard\WebmasterSectionsController;
use App\Http\Controllers\Dashboard\WebmasterSettingsController;



// Admin Home
Route::get('/', [DashboardController::class, 'index'])->name('adminHome');
//Search
Route::get('/search', [DashboardController::class, 'search'])->name('adminSearch');
Route::post('/find', [DashboardController::class, 'find'])->name('adminFind');

// Webmaster
Route::get('/webmaster', [WebmasterSettingsController::class, 'edit'])->name('webmasterSettings');
Route::get('/webmaster-save/{tab?}', [WebmasterSettingsController::class, 'saved'])->name('webmasterSettingsSaved');
Route::post('/webmaster', [WebmasterSettingsController::class, 'update'])->name('webmasterSettingsUpdate');
Route::post('/webmaster/languages/store', [WebmasterSettingsController::class, 'language_store'])->name('webmasterLanguageStore');
Route::post('/webmaster/languages/store', [WebmasterSettingsController::class, 'language_store'])->name('webmasterLanguageStore');
Route::post('/webmaster/languages/update', [WebmasterSettingsController::class, 'language_update'])->name('webmasterLanguageUpdate');
Route::get('/webmaster/languages/destroy/{id}', [WebmasterSettingsController::class, 'language_destroy'])->name('webmasterLanguageDestroy');
Route::get('/webmaster/seo/repair', [WebmasterSettingsController::class, 'seo_repair'])->name('webmasterSEORepair');

Route::post('/webmaster/mail/smtp', [WebmasterSettingsController::class, 'mail_smtp_check'])->name('mailSMTPCheck');
Route::post('/webmaster/mail/test', [WebmasterSettingsController::class, 'mail_test'])->name('mailTest');


Route::post('/webmaster-license', [WebmasterLicenseController::class, 'index'])->name('licenseCheck');

// Webmaster Banners
Route::get('/webmaster/banners', [WebmasterBannersController::class, 'index'])->name('WebmasterBanners');
Route::get('/webmaster/banners/create', [WebmasterBannersController::class, 'create'])->name('WebmasterBannersCreate');
Route::post('/webmaster/banners/store', [WebmasterBannersController::class, 'store'])->name('WebmasterBannersStore');
Route::get('/webmaster/banners/{id}/edit', [WebmasterBannersController::class, 'edit'])->name('WebmasterBannersEdit');
Route::post('/webmaster/banners/{id}/update', [WebmasterBannersController::class, 'update'])->name('WebmasterBannersUpdate');
Route::get(
    '/webmaster/banners/destroy/{id}',
    [WebmasterBannersController::class, 'destroy']
)->name('WebmasterBannersDestroy');
Route::post(
    '/webmaster/banners/updateAll',
    [WebmasterBannersController::class, 'updateAll']
)->name('WebmasterBannersUpdateAll');

// Webmaster Sections
Route::get('/webmaster/sections', [WebmasterSectionsController::class, 'index'])->name('WebmasterSections');
Route::get('/webmaster/sections/create', [WebmasterSectionsController::class, 'create'])->name('WebmasterSectionsCreate');
Route::post('/webmaster/sections/store', [WebmasterSectionsController::class, 'store'])->name('WebmasterSectionsStore');
Route::get('/webmaster/sections/{id}/edit', [WebmasterSectionsController::class, 'edit'])->name('WebmasterSectionsEdit');
Route::post(
    '/webmaster/sections/{id}/update',
    [WebmasterSectionsController::class, 'update']
)->name('WebmasterSectionsUpdate');

Route::post('/webmaster/sections/{id}/seo', [WebmasterSectionsController::class, 'seo'])->name('WebmasterSectionsSEOUpdate');

Route::get(
    '/webmaster/sections/destroy/{id}',
    [WebmasterSectionsController::class, 'destroy']
)->name('WebmasterSectionsDestroy');
Route::post(
    '/webmaster/sections/updateAll',
    [WebmasterSectionsController::class, 'updateAll']
)->name('WebmasterSectionsUpdateAll');

// Webmaster Sections :Custom Fields
Route::get('/webmaster/{webmasterId}/fields', [WebmasterSectionsController::class, 'webmasterFields'])->name('webmasterFields');
Route::get('/{webmasterId}/fields/create', [WebmasterSectionsController::class, 'fieldsCreate'])->name('webmasterFieldsCreate');
Route::post('/webmaster/{webmasterId}/fields/store', [WebmasterSectionsController::class, 'fieldsStore'])->name('webmasterFieldsStore');
Route::get('/webmaster/{webmasterId}/fields/{field_id}/edit', [WebmasterSectionsController::class, 'fieldsEdit'])->name('webmasterFieldsEdit');
Route::post('/webmaster/{webmasterId}/fields/{field_id}/update', [WebmasterSectionsController::class, 'fieldsUpdate'])->name('webmasterFieldsUpdate');
Route::get('/webmaster/{webmasterId}/fields/destroy/{field_id}', [WebmasterSectionsController::class, 'fieldsDestroy'])->name('webmasterFieldsDestroy');
Route::post('/webmaster/{webmasterId}/fields/updateAll', [WebmasterSectionsController::class, 'fieldsUpdateAll'])->name('webmasterFieldsUpdateAll');

// Settings
Route::get('/settings', [SettingsController::class, 'edit'])->name('settings');
Route::post('/settings', [SettingsController::class, 'updateSiteInfo'])->name('settingsUpdateSiteInfo');

// Ad. Banners
Route::get('/banners', [BannersController::class, 'index'])->name('Banners');
Route::get('/banners/create/{sectionId}', [BannersController::class, 'create'])->name('BannersCreate');
Route::post('/banners/store', [BannersController::class, 'store'])->name('BannersStore');
Route::get('/banners/{id}/edit', [BannersController::class, 'edit'])->name('BannersEdit');
Route::post('/banners/{id}/update', [BannersController::class, 'update'])->name('BannersUpdate');
Route::get('/banners/destroy/{id?}', [BannersController::class, 'destroy'])->name('BannersDestroy');
Route::post('/banners/updateAll', [BannersController::class, 'updateAll'])->name('BannersUpdateAll');

// Sections
Route::get('/{webmasterId}/categories', [CategoriesController::class, 'index'])->name('categories');
Route::get('/{webmasterId}/categories/create', [CategoriesController::class, 'create'])->name('categoriesCreate');
Route::post('/{webmasterId}/categories/store', [CategoriesController::class, 'store'])->name('categoriesStore');
Route::get('/{webmasterId}/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('categoriesEdit');
Route::post('/{webmasterId}/categories/{id}/update', [CategoriesController::class, 'update'])->name('categoriesUpdate');
Route::post('/{webmasterId}/categories/{id}/seo', [CategoriesController::class, 'seo'])->name('categoriesSEOUpdate');
Route::get('/{webmasterId}/categories/destroy/{id?}', [CategoriesController::class, 'destroy'])->name('categoriesDestroy');
Route::post('/{webmasterId}/categories/updateAll', [CategoriesController::class, 'updateAll'])->name('categoriesUpdateAll');

// Topics
Route::get('/{webmasterId}/topics', [TopicsController::class, 'index'])->name('topics');
Route::post('/topics-list', [TopicsController::class, 'list'])->name('topicsList');
Route::get('/{webmasterId}/view/{id}', [TopicsController::class, 'view'])->name('topicView');
Route::get('/{webmasterId}/topics/create', [TopicsController::class, 'create'])->name('topicsCreate');
Route::post('/{webmasterId}/topics/store', [TopicsController::class, 'store'])->name('topicsStore');
Route::get('/{webmasterId}/topics/{id}/edit', [TopicsController::class, 'edit'])->name('topicsEdit');
Route::get('/{webmasterId}/topics/{id}/clone', [TopicsController::class, 'clone'])->name('topicsClone');
Route::post('/{webmasterId}/topics/{id}/update', [TopicsController::class, 'update'])->name('topicsUpdate');
Route::get('/{webmasterId}/topics/destroy/{id?}', [TopicsController::class, 'destroy'])->name('topicsDestroy');
Route::post('/{webmasterId}/topics/updateAll', [TopicsController::class, 'updateAll'])->name('topicsUpdateAll');
Route::get('/{webmasterId}/print', [TopicsController::class, 'print'])->name('topicsPrint');
// Topics :SEO
Route::post('/{webmasterId}/topics/{id}/seo', [TopicsController::class, 'seo'])->name('topicsSEOUpdate');
// Topics :Photos
Route::post('/topics/upload', [TopicsController::class, 'upload'])->name('topicsPhotosUpload');
Route::post('/{webmasterId}/topics/{id}/photos', [TopicsController::class, 'photos'])->name('topicsPhotosEdit');
Route::get(
    '/{webmasterId}/topics/{id}/photos/{photo_id}/destroy',
    [TopicsController::class, 'photosDestroy']
)->name('topicsPhotosDestroy');
Route::post(
    '/{webmasterId}/topics/{id}/photos/updateAll',
    [TopicsController::class, 'photosUpdateAll']
)->name('topicsPhotosUpdateAll');


Route::post('/topics-import', [TopicsController::class, 'import'])->name('topicsImport');



// Topics :Files
Route::get('/{webmasterId}/topics/{id}/files', [TopicsController::class, 'topicsFiles'])->name('topicsFiles');
Route::get(
    '/{webmasterId}/topics/{id}/files/create',
    [TopicsController::class, 'filesCreate']
)->name('topicsFilesCreate');
Route::post(
    '/{webmasterId}/topics/{id}/files/store',
    [TopicsController::class, 'filesStore']
)->name('topicsFilesStore');
Route::get(
    '/{webmasterId}/topics/{id}/files/{file_id}/edit',
    [TopicsController::class, 'filesEdit']
)->name('topicsFilesEdit');
Route::post(
    '/{webmasterId}/topics/{id}/files/{file_id}/update',
    [TopicsController::class, 'filesUpdate']
)->name('topicsFilesUpdate');
Route::get(
    '/{webmasterId}/topics/{id}/files/destroy/{file_id}',
    [TopicsController::class, 'filesDestroy']
)->name('topicsFilesDestroy');
Route::post(
    '/{webmasterId}/topics/{id}/files/updateAll',
    [TopicsController::class, 'filesUpdateAll']
)->name('topicsFilesUpdateAll');


// Topics :Related
Route::get('/{webmasterId}/topics/{id}/related', [TopicsController::class, 'topicsRelated'])->name('topicsRelated');
Route::get('/relatedLoad/{id}', [TopicsController::class, 'topicsRelatedLoad'])->name('topicsRelatedLoad');
Route::get(
    '/{webmasterId}/topics/{id}/related/create',
    [TopicsController::class, 'relatedCreate']
)->name('topicsRelatedCreate');
Route::post(
    '/{webmasterId}/topics/{id}/related/store',
    [TopicsController::class, 'relatedStore']
)->name('topicsRelatedStore');
Route::get(
    '/{webmasterId}/topics/{id}/related/destroy/{related_id}',
    [TopicsController::class, 'relatedDestroy']
)->name('topicsRelatedDestroy');
Route::post(
    '/{webmasterId}/topics/{id}/related/updateAll',
    [TopicsController::class, 'relatedUpdateAll']
)->name('topicsRelatedUpdateAll');
// Topics :Comments
Route::get('/{webmasterId}/topics/{id}/comments', [TopicsController::class, 'topicsComments'])->name('topicsComments');
Route::get(
    '/{webmasterId}/topics/{id}/comments/create',
    [TopicsController::class, 'commentsCreate']
)->name('topicsCommentsCreate');
Route::post(
    '/{webmasterId}/topics/{id}/comments/store',
    [TopicsController::class, 'commentsStore']
)->name('topicsCommentsStore');
Route::get(
    '/{webmasterId}/topics/{id}/comments/{comment_id}/edit',
    [TopicsController::class, 'commentsEdit']
)->name('topicsCommentsEdit');
Route::post(
    '/{webmasterId}/topics/{id}/comments/{comment_id}/update',
    [TopicsController::class, 'commentsUpdate']
)->name('topicsCommentsUpdate');
Route::get(
    '/{webmasterId}/topics/{id}/comments/destroy/{comment_id}',
    [TopicsController::class, 'commentsDestroy']
)->name('topicsCommentsDestroy');
Route::post(
    '/{webmasterId}/topics/{id}/comments/updateAll',
    [TopicsController::class, 'commentsUpdateAll']
)->name('topicsCommentsUpdateAll');
// Topics :Maps
Route::get('/{webmasterId}/topics/{id}/maps', [TopicsController::class, 'topicsMaps'])->name('topicsMaps');
Route::get('/{webmasterId}/topics/{id}/maps/create', [TopicsController::class, 'mapsCreate'])->name('topicsMapsCreate');
Route::post('/{webmasterId}/topics/{id}/maps/store', [TopicsController::class, 'mapsStore'])->name('topicsMapsStore');
Route::get('/{webmasterId}/topics/{id}/maps/{map_id}/edit', [TopicsController::class, 'mapsEdit'])->name('topicsMapsEdit');
Route::post(
    '/{webmasterId}/topics/{id}/maps/{map_id}/update',
    [TopicsController::class, 'mapsUpdate']
)->name('topicsMapsUpdate');
Route::get(
    '/{webmasterId}/topics/{id}/maps/destroy/{map_id}',
    [TopicsController::class, 'mapsDestroy']
)->name('topicsMapsDestroy');
Route::post(
    '/{webmasterId}/topics/{id}/maps/updateAll',
    [TopicsController::class, 'mapsUpdateAll']
)->name('topicsMapsUpdateAll');

// keditor
Route::get('/keditor/{topic_id?}', [TopicsController::class, 'keditor'])->name('keditor');
Route::get('/keditor-snippets', [TopicsController::class, 'keditor_snippets'])->name('keditorSnippets');
Route::post('/keditor-save', [TopicsController::class, 'keditor_save'])->name('keditorSave');

// Contacts Groups
Route::post('/contacts/storeGroup', [ContactsController::class, 'storeGroup'])->name('contactsStoreGroup');
Route::get('/contacts/{id}/editGroup', [ContactsController::class, 'editGroup'])->name('contactsEditGroup');
Route::post('/contacts/{id}/updateGroup', [ContactsController::class, 'updateGroup'])->name('contactsUpdateGroup');
Route::get('/contacts/destroyGroup/{id}', [ContactsController::class, 'destroyGroup'])->name('contactsDestroyGroup');
// Contacts
Route::get('/contacts/{group_id?}', [ContactsController::class, 'index'])->name('contacts');
Route::post('/contacts/store', [ContactsController::class, 'store'])->name('contactsStore');
Route::post('/contacts/search', [ContactsController::class, 'search'])->name('contactsSearch');
Route::get('/contacts/{id}/edit', [ContactsController::class, 'edit'])->name('contactsEdit');
Route::post('/contacts/{id}/update', [ContactsController::class, 'update'])->name('contactsUpdate');
Route::get('/contacts/destroy/{id}', [ContactsController::class, 'destroy'])->name('contactsDestroy');
Route::post('/contacts/updateAll', [ContactsController::class, 'updateAll'])->name('contactsUpdateAll');

// WebMails Groups
Route::post('/webmails/storeGroup', [WebmailsController::class, 'storeGroup'])->name('webmailsStoreGroup');
Route::get('/webmails/{id}/editGroup', [WebmailsController::class, 'editGroup'])->name('webmailsEditGroup');
Route::post('/webmails/{id}/updateGroup', [WebmailsController::class, 'updateGroup'])->name('webmailsUpdateGroup');
Route::get('/webmails/destroyGroup/{id}', [WebmailsController::class, 'destroyGroup'])->name('webmailsDestroyGroup');
// WebMails
Route::post('/webmails/store', [WebmailsController::class, 'store'])->name('webmailsStore');
Route::post('/webmails/search', [WebmailsController::class, 'search'])->name('webmailsSearch');
Route::get('/webmails/{id}/edit', [WebmailsController::class, 'edit'])->name('webmailsEdit');
Route::get('/webmails/{group_id?}/{wid?}/{stat?}/{contact_email?}', [WebmailsController::class, 'index'])->name('webmails');
Route::post('/webmails/{id}/update', [WebmailsController::class, 'update'])->name('webmailsUpdate');
Route::get('/webmails/destroy/{id}', [WebmailsController::class, 'destroy'])->name('webmailsDestroy');
Route::post('/webmails/updateAll', [WebmailsController::class, 'updateAll'])->name('webmailsUpdateAll');

// Calendar
Route::get('/calendar', [EventsController::class, 'index'])->name('calendar');
Route::get('/calendar/create', [EventsController::class, 'create'])->name('calendarCreate');
Route::post('/calendar/store', [EventsController::class, 'store'])->name('calendarStore');
Route::get('/calendar/{id}/edit', [EventsController::class, 'edit'])->name('calendarEdit');
Route::post('/calendar/{id}/update', [EventsController::class, 'update'])->name('calendarUpdate');
Route::get('/calendar/destroy/{id}', [EventsController::class, 'destroy'])->name('calendarDestroy');
Route::get('/calendar/updateAll', [EventsController::class, 'updateAll'])->name('calendarUpdateAll');
Route::post('/calendar/{id}/extend', [EventsController::class, 'extend'])->name('calendarExtend');

// Analytics
Route::get('/ip/{ip_code?}', [AnalyticsController::class, 'ip'])->name('visitorsIP');
Route::post('/ip/search', [AnalyticsController::class, 'search'])->name('visitorsSearch');
Route::post('/analytics/{stat}', [AnalyticsController::class, 'filter'])->name('analyticsFilter');
Route::get('/analytics/{stat?}', [AnalyticsController::class, 'index'])->name('analytics');
Route::get('/visitors', [AnalyticsController::class, 'visitors'])->name('visitors');

// Users & Permissions
Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/users/create/', [UsersController::class, 'create'])->name('usersCreate');
Route::post('/users/store', [UsersController::class, 'store'])->name('usersStore');
Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('usersEdit');
Route::post('/users/{id}/update', [UsersController::class, 'update'])->name('usersUpdate');
Route::get('/users/destroy/{id}', [UsersController::class, 'destroy'])->name('usersDestroy');
Route::post('/users/updateAll', [UsersController::class, 'updateAll'])->name('usersUpdateAll');

Route::get('/users/permissions/create/', [UsersController::class, 'permissions_create'])->name('permissionsCreate');
Route::post('/users/permissions/store', [UsersController::class, 'permissions_store'])->name('permissionsStore');
Route::get('/users/permissions/{id}/edit', [UsersController::class, 'permissions_edit'])->name('permissionsEdit');
Route::post('/users/permissions/{id}/update', [UsersController::class, 'permissions_update'])->name('permissionsUpdate');
Route::post('/users/permissions/{id}/save', [UsersController::class, 'update_custom_home'])->name('permissionsHomePageUpdate');
Route::get('/users/permissions/destroy/{id}', [UsersController::class, 'permissions_destroy'])->name('permissionsDestroy');

Route::post('/permissions-links/store', [UsersController::class, 'links_store'])->name('customLinksStore');
Route::post('/permissions-links/update', [UsersController::class, 'links_update'])->name('customLinksUpdate');
Route::get('/permissions-links/edit/{id?}/{p_id?}', [UsersController::class, 'links_edit'])->name('customLinksEdit');
Route::get('/permissions-links/destroy/{id?}/{p_id?}', [UsersController::class, 'links_destroy'])->name('customLinksDestroy');
Route::get('/permissions-links/list/{p_id?}', [UsersController::class, 'links_list'])->name('customLinksList');


// Menus
Route::post('/menus/store/parent', [MenusController::class, 'storeMenu'])->name('parentMenusStore');
Route::get('/menus/parent/{id}/edit', [MenusController::class, 'editMenu'])->name('parentMenusEdit');
Route::post('/menus/{id}/update/{ParentMenuId}', [MenusController::class, 'updateMenu'])->name('parentMenusUpdate');
Route::get('/menus/parent/destroy/{id}', [MenusController::class, 'destroyMenu'])->name('parentMenusDestroy');

Route::get('/menus/{ParentMenuId?}', [MenusController::class, 'index'])->name('menus');
Route::get('/menus/create/{ParentMenuId?}', [MenusController::class, 'create'])->name('menusCreate');
Route::post('/menus/store/{ParentMenuId?}', [MenusController::class, 'store'])->name('menusStore');
Route::get('/menus/{id}/edit/{ParentMenuId?}', [MenusController::class, 'edit'])->name('menusEdit');
Route::post('/menus/{id}/update', [MenusController::class, 'update'])->name('menusUpdate');
Route::get('/menus/destroy/{id}', [MenusController::class, 'destroy'])->name('menusDestroy');
Route::post('/menus/updateAll', [MenusController::class, 'updateAll'])->name('menusUpdateAll');


Route::get('file-manager', [FileManagerController::class, 'index'])->name('FileManager');
Route::get('files-manager', [FileManagerController::class, 'manager'])->name('FilesManager');

// No Permission
Route::get('/403', [DashboardController::class, 'page_403'])->name('NoPermission');

// Clear Cache
Route::get('/cache-clear', [DashboardController::class, 'cache_clear'])->name('cacheClear');
Route::get('/cache-cleared', [DashboardController::class, 'cache_cleared'])->name('cacheCleared');
// logout
Route::get('/logout', [DashboardController::class, 'logout'])->name('adminLogout');

// Currency
Route::get('/currency', [CurrencyController::class, 'index'])->name('currency.index');
Route::get('/currency/create', [CurrencyController::class, 'create'])->name('currency.Create');
Route::post('/currency/store', [CurrencyController::class, 'store'])->name('currency.Store');
Route::get('/currency/{id}/edit', [CurrencyController::class, 'edit'])->name('currency.Edit');
Route::post('/currency/{id}/update', [CurrencyController::class, 'update'])->name('currency.Update');
Route::get('/currency/updateStatus/{id}', [CurrencyController::class, 'updateStatus'])->name('currency.updateStatus');

// Country
Route::get('/country', [CountryController::class, 'index'])->name('country.index');
Route::get('/country/create', [CountryController::class, 'create'])->name('country.Create');
Route::post('/country/store', [CountryController::class, 'store'])->name('country.Store');
Route::get('/country/{id}/edit', [CountryController::class, 'edit'])->name('country.Edit');
Route::post('/country/{id}/update', [CountryController::class, 'update'])->name('country.Update');
Route::get('/country/updateStatus/{id}', [CountryController::class, 'updateStatus'])->name('country.updateStatus');

// Type Activity
Route::get('/typeActivity', [TypeActivityController::class, 'index'])->name('typeActivity.index');
Route::get('/typeActivity/create', [TypeActivityController::class, 'create'])->name('typeActivity.Create');
Route::post('/typeActivity/store', [TypeActivityController::class, 'store'])->name('typeActivity.Store');
Route::get('/typeActivity/{id}/edit', [TypeActivityController::class, 'edit'])->name('typeActivity.Edit');
Route::post('/typeActivity/{id}/update', [TypeActivityController::class, 'update'])->name('typeActivity.Update');
Route::get('/typeActivity/updateStatus/{id}', [TypeActivityController::class, 'updateStatus'])->name('typeActivity.updateStatus');

// Companies
Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
Route::get('/company/create', [CompanyController::class, 'create'])->name('company.Create');
Route::post('/company/store', [CompanyController::class, 'store'])->name('company.Store');
Route::get('/company/{company}/edit', [CompanyController::class, 'edit'])->name('company.Edit');
Route::post('/company/{id}/update', [CompanyController::class, 'update'])->name('company.Update');
Route::get('/status/{id}', [CompanyController::class, 'updateStatus'])->name('company.updateStatus');
Route::get('/getCities/{ids}', [CompanyController::class, 'getCities'])->name('getCities');
Route::get('/getRating/{companyId}', [CompanyController::class, 'getRating'])->name('getRating');
// get company for modal to get follower
Route::get('/get-company/{id}', [CompanyController::class, 'getCompany'])->name('get-company');



// City
Route::get('/city', [CityController::class, 'index'])->name('city.index');
Route::get('/city/create', [CityController::class, 'create'])->name('city.Create');
Route::post('/city/store', [CityController::class, 'store'])->name('city.Store');
Route::get('/city/{id}/edit', [CityController::class, 'edit'])->name('city.Edit');
Route::post('/city/{id}/update', [CityController::class, 'update'])->name('city.Update');
Route::get('/city/updateStatus/{id}', [CityController::class, 'updateStatus'])->name('city.updateStatus');

// Shipments
Route::get('/shipment', [ShipmentController::class, 'index'])->name('shipment.index');
Route::post('/shipmentStatus/{id}', [ShipmentController::class, 'updateStatus'])->name('shipment.updateStatus');

// Chat
Route::get('/chat', [ChatController::class, 'getChats'])->name('chat.index');
Route::get('chats/messages/{id}', [ChatController::class, 'fetchChatMessages'])->name('chats.fetchMessages');
Route::post('messages', [ChatController::class, 'storeMessage'])->name('storeMessage');
// Get all chats
Route::get('/chats/all', [ChatController::class, 'getAllChats'])->name('chats.all');

// Get chats with unread messages
Route::get('/chats/unread', [ChatController::class, 'getUnreadChats'])->name('chats.unread');

// Get chats with read messages
Route::get('/chats/read', [ChatController::class, 'getReadChats'])->name('chats.read');
// Route for real-time chat search
Route::get('/search-chats', [ChatController::class, 'searchChats'])->name('searchChats');

