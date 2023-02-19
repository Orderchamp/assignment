<?php

namespace App\Domain\Cart\Repositories;

use App\Domain\Cart\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

interface CartItemRepositoryInterface
{
    public function save(CartItem $cartItem): CartItem;

    public function getById(int $id): ?CartItem;

    public function update(CartItem $cartItem, array $data): CartItem;

    public function delete(CartItem $cartItem): void;

    public function getAll(): Collection;

    public function getByGuestCartId(string $guestCartId);

    public function getByUserId(string $userId): Collection;

    public function deleteByGuestCartId(string $guestCartId, int $productId = null): void;

    public function deleteByUserId(int $userId, int $productId = null): void;
}
