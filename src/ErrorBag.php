<?php

namespace Edalzell\ErrorBag;

use Illuminate\Support\MessageBag;
use Statamic\Tags\Tags;

class ErrorBag extends Tags
{
    public function index()
    {
        if (! $errors = $this->getMessageBag()) {
            return false;
        }

        return ['fields' => $this->formatErrors($errors->getMessages())];
    }

    /**
     * {{ error:fieldname }}.
     */
    public function wildcard(string $name)
    {
        if (! $errors = $this->getMessageBag()) {
            return false;
        }

        if (! $messages = $errors->get($name)) {
            return false;
        }

        return collect($messages)
            ->map(function ($error) {
                return ['field_error' => $error];
            });
    }

    private function getMessageBag(): ?MessageBag
    {
        /** @var \Illuminate\Support\ViewErrorBag */
        $errorBag = view()->shared('errors');

        if ($errorBag->count() === 0) {
            return null;
        }

        return $errorBag->getBag($this->params->get('bag', 'default'));
    }

    private function formatErrors(array $messages): array
    {
        return collect($messages)
            ->map(function ($errors, $field) {
                return ['field' => $field, 'field_errors' => $errors];
            })->values()
            ->all();
    }
}
