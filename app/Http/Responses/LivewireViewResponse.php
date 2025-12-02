<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;

class LivewireViewResponse implements LoginViewResponse, RegisterViewResponse
{
    /**
     * The Livewire component class to be rendered.
     *
     * @var string
     */
    protected $component;

    /**
     * Create a new response instance.
     *
     * @param  string  $componentClass
     * @return void
     */
    public function __construct(string $componentClass)
    {
        $this->component = $componentClass;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // This correctly calls the full Livewire component lifecycle,
        // including the render() method and layout attachment.
        return app()->call($this->component);
    }
}
