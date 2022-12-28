<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartRepository
{
    public function add(Product $product): int
    {
        \Cart::session(auth()->user()->id)
            ->add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'attributes' => [],
                'associatedModel' => $product
            ]);

        return $this->count();
    }

    public function delete($id): int
    {
        \Cart::session(auth()->user()->id)->remove($id);

        return $this->count();
    }

    public function content(): Collection
    {
        return \Cart::session(auth()->user()->id)
            ->getContent();
    }

    public function jsonOrderItems(): string
    {
        return $this
            ->content()
            ->map(function ($orderItem) {
                return [
                    'name' => $orderItem->name,
                    'quantity' => $orderItem->quantity,
                    'price' => $orderItem->price,
                ];
            })
            ->toJson();
    }

    public function count(): int
    {
        return $this->content()
            ->sum('quantity');
    }

    public function total(): int
    {
        return \Cart::session(auth()->user()->id)
            ->getTotal();
    }

    public function decrease($id)
    {
        if ($this->getItem($id)->quantity === 1) {
            return $this->delete($id);
        }

        \Cart::session(auth()->user()->id)
            ->update($id, array(
                'quantity' => - 1
            ));
    }

    public function increase($id): void
    {
        \Cart::session(auth()->user()->id)
            ->update($id, array(
                'quantity' => + 1
            ));
    }

    public function clear()
    {
        \Cart::session(auth()->user()->id)->clear();
    }

    private function getItem($id)
    {
        return \Cart::session(auth()->user()->id)
            ->get($id);
    }
}