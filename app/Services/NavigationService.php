<?php

namespace App\Services;

use App\Enums\UserRole;

class NavigationService
{
    /**
     * Returns the master list of all possible panel menu items.
     */
    public function getPanelMenu(): array
    {
        return [
            // ADMIN Menu
            [
                'title' => 'Dashboard',
                'icon' => 'squares-four',
                'icon_style' => 'fill',
                'route' => 'admin.dashboard',
                'roles' => [UserRole::ADMIN],
            ],
            [
                'title' => 'Manajemen Booking',
                'icon' => 'briefcase',
                'icon_style' => null,
                'route' => 'admin.bookings.index',
                'roles' => [UserRole::ADMIN],
            ],
            [
                'title' => 'Manajemen Paket',
                'icon' => 'package',
                'icon_style' => null,
                'route' => 'admin.packages.index',
                'roles' => [UserRole::ADMIN],
                'children' => [
                    ['title' => 'Daftar Paket', 'route' => 'admin.packages.index'],
                ],
            ],
            [
                'title' => 'Inquiries Masuk',
                'icon' => 'whatsapp-logo',
                'icon_style' => null,
                'route' => 'admin.inquiries.index',
                'roles' => [UserRole::ADMIN],
            ],
            [
                'title' => 'Data Jamaah',
                'icon' => 'users',
                'icon_style' => null,
                'route' => 'admin.users.index',
                'roles' => [UserRole::ADMIN],
            ],
            [
                'title' => 'Artikel & Blog',
                'icon' => 'newspaper',
                'icon_style' => null,
                'route' => 'admin.posts.index',
                'roles' => [UserRole::ADMIN],
            ],
            [
                'title' => 'Manajemen Testimoni',
                'icon' => 'quotes',
                'icon_style' => null,
                'route' => 'admin.testimonials.index',
                'roles' => [UserRole::ADMIN],
            ],

            // USER Menu
            [
                'title' => 'Dashboard',
                'icon' => 'squares-four',
                'icon_style' => 'fill',
                'route' => 'user.dashboard',
                'roles' => [UserRole::USER],
            ],
            [
                'title' => 'Paket Dipesan',
                'icon' => 'briefcase',
                'icon_style' => null,
                'route' => 'user.bookings.index',
                'roles' => [UserRole::USER],
            ],
            [
                'title' => 'Wishlist Saya',
                'icon' => 'heart',
                'icon_style' => null,
                'route' => 'user.wishlist.index',
                'roles' => [UserRole::USER],
            ],
            [
                'title' => 'Riwayat Inquiry',
                'icon' => 'whatsapp-logo', // Pastikan icon ini ada di library icon Anda
                'icon_style' => null,
                'route' => 'user.inquiries.index',
                'roles' => [UserRole::USER],
            ],
            [
                'title' => 'Profil Saya',
                'icon' => 'user',
                'icon_style' => null,
                'route' => 'user.profile.show',
                'roles' => [UserRole::USER],
            ],
        ];
    }

    /**
     * Filters the master menu list based on the user's role.
     */
    public function getFilteredMenuForRole(UserRole $userRole): array
    {
        $menu = $this->getPanelMenu();

        return array_filter($menu, function ($item) use ($userRole) {
            return in_array($userRole, $item['roles']);
        });
    }
}
