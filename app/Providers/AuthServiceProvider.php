<?php

Gate::before(function ($user) {
    if ($user->hasRole('admin')) {
        return true;
    }
});
