<?php

namespace App\Http\Livewire;

use App\Traits\HasFormTarget;
use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\SerializableClosure\SerializableClosure;
use Livewire\Component;

abstract class CrudComponent extends Component
{
    use AuthorizesRequests,
        HasFormTarget;

    public $authorization;

    public $callbacks = [];

    public $redirection;

    abstract public function registerCrud(): void;

    protected function authorizeCrud($model, $parameter = null): void
    {
        $parameter = $parameter ?: Str::snake(class_basename($model));

        $this->authorization = [$model, $parameter];
    }

    protected function beforeCreate(Closure $closure)
    {
        $serialized = serialize(new SerializableClosure($closure));

        $this->callbacks['beforeCreate'] = $serialized;

        return $this;
    }

    protected function onCreate(Closure $closure)
    {
        $serialized = serialize(new SerializableClosure($closure));

        $this->callbacks['onCreate'] = $serialized;

        return $this;
    }

    public function create()
    {
        $data = $this->validateData('beforeCreate');

        if ($this->authorization) {
            [$model, $parameter] = $this->authorization;

            $this->authorize('create', $model);
        }

        $onClosure = unserialize($this->callbacks['onCreate'])->getClosure();
        $onClosure($this, $data);

        if ($this->redirection) {
            $this->redirectTo = $this->redirection;
        }
    }

    protected function beforeUpdate(Closure $closure)
    {
        $serialized = serialize(new SerializableClosure($closure));

        $this->callbacks['beforeUpdate'] = $serialized;

        return $this;
    }

    protected function onUpdate(Closure $closure)
    {
        $serialized = serialize(new SerializableClosure($closure));

        $this->callbacks['update'] = $serialized;

        return $this;
    }

    public function update()
    {
        $data = $this->validateData('beforeUpdate');

        if ($this->authorization) {
            [$model, $parameter] = $this->authorization;

            $this->authorize('update', $this->{$parameter});
        }

        $onClosure = unserialize($this->callbacks['update'])->getClosure();
        $onClosure($this, $data);

        if ($this->redirection) {
            $this->redirectTo = $this->redirection;
        }
    }

    protected function onDelete(Closure $closure)
    {
        $serialized = serialize(new SerializableClosure($closure));

        $this->callbacks['delete'] = $serialized;

        return $this;
    }

    public function delete()
    {
        if ($this->authorization) {
            [$model, $parameter] = $this->authorization;

            $this->authorize('delete', $this->{$parameter});
        }

        $closure = unserialize($this->callbacks['delete'])->getClosure();

        $closure($this);

        if ($this->redirection) {
            $this->redirectTo = $this->redirection;
        }
    }

    public function validateData(string $type)
    {
        if (! in_array($type, ['beforeCreate', 'beforeUpdate'])) {
            throw new \InvalidArgumentException('Invalid type');
        }

        $inputData = $this->state;

        if (isset($this->callbacks[$type])) {
            $beforeClosure = unserialize($this->callbacks[$type])->getClosure();
            $inputData = $beforeClosure($inputData);
        }

        return Validator::make($inputData, isset($this->rules) ? $this->rules : $this->rules())->validate();
    }

    public function redirect($url)
    {
        $this->redirection = $url;
    }

    public function redirectRoute($name, $parameters = [], $absolute = true)
    {
        $this->redirection = route($name, $parameters, $absolute);
    }

    public function redirectAction($name, $parameters = [], $absolute = true)
    {
        $this->redirection = action($name, $parameters, $absolute);
    }
}
