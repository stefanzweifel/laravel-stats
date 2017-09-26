<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;

class ComponentConfiguration
{
    /**
     * Get a Collection of Laravel Components and how they can be identified.
     *
     * @return Collection
     */
    public function get()
    {
        return collect([
            [
                'name'    => 'Controllers',
                'extends' => \Illuminate\Routing\Controller::class,
            ],
            [
                'name'    => 'Models',
                'extends' => \Illuminate\Database\Eloquent\Model::class,
            ],
            [
                'name'    => 'Commands',
                'extends' => \Illuminate\Console\Command::class,
            ],
            [
                'name' => 'Events',
                'uses' => \Illuminate\Foundation\Events\Dispatchable::class,
            ],
            [
                'name'    => 'Mails',
                'extends' => \Illuminate\Mail\Mailable::class,
            ],
            [
                'name'    => 'Notifications',
                'extends' => \Illuminate\Notifications\Notification::class,
            ],
            [
                'name' => 'Jobs',
                'uses' => \Illuminate\Foundation\Bus\Dispatchable::class,
            ],
            [
                'name'    => 'Migrations',
                'extends' => \Illuminate\Database\Migrations\Migration::class,
            ],
            [
                'name'    => 'Seeders',
                'extends' => \Illuminate\Database\Seeder::class,
            ],
            [
                'name'    => 'Resources',
                'extends' => \Illuminate\Http\Resources\Json\Resource::class,
            ],
            [
                'name'       => 'Rules',
                'implements' => \Illuminate\Contracts\Validation\Rule::class,
            ],
            [
                'name'    => 'Requests',
                'extends' => \Illuminate\Foundation\Http\FormRequest::class,
            ],
            [
                'name'    => 'Service Providers',
                'extends' => \Illuminate\Support\ServiceProvider::class,
            ],
            [
                'name' => 'Policies',
                // TODO
            ],
            [
                'name' => 'Middlewares',
                // TODO
            ],
            [
                'name' => 'Test',
                // TODO
            ],
        ]);
    }
}
