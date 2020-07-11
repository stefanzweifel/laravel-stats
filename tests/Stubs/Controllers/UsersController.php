<?php

namespace Wnx\LaravelStats\Tests\Stubs\Controllers;

use Wnx\LaravelStats\Tests\Stubs\Requests\UserRequest;

class UsersController extends Controller
{
    public function index(array $filter = [])
    {
        return [];
    }

    public function create()
    {
        return [];
    }

    public function store(UserRequest $request)
    {
        return [];
    }

    public function show()
    {
        return [];
    }

    public function edit()
    {
        return [];
    }

    public function update(UserRequest $request)
    {
        return [];
    }

    public function delete()
    {
        return [];
    }
}
