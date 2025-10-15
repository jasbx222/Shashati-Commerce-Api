<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Auth\EditProfile;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->colors([
                'primary' => Color::Sky,
            ])
            ->font('Poppins')
            ->favicon(asset('images/logo.png'))
            ->brandName(env('APP_NAME'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->navigationGroups([
                NavigationGroup::make('الطلبات')
                    ->label('الطلبات'),
                NavigationGroup::make('المنتجات')
                    ->label('المنتجات'),
                NavigationGroup::make('العملاء')
                    ->label('العملاء'),
                NavigationGroup::make('الاعلانات')
                    ->label('الاعلانات'),
                NavigationGroup::make('الاعدادات')
                    ->label('الاعدادات'),

            ])
            // ->navigationItems([
            //     NavigationItem::make('Profile') 
            //         ->label(fn (): string => __('filament-panels::pages/auth/edit-profile.label'))
            //         ->url('profile') // Replace with your route name
            //         ->icon('heroicon-o-user-circle')
            //         ->isActiveWhen(fn (): bool => request()->routeIs(EditProfile::getRelativeRouteName())), 
            // ])
            ->sidebarCollapsibleOnDesktop();
    }
}
