<?php

namespace PageCall\Interfaces;

/**
 * Interface PageCall
 * Copyright 2018 ppLINK(https://www.pplink.net/), Inc.
 */
interface PageCall
{
    public function connectIn(array $data): array;
    public function connectReplay(array $data): array;
    public function connectReplayLegacy(array $data): array;
}