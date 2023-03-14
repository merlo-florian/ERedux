<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: CartItemRepository::class)]
#[ApiResource]
class CartItem
{
    #[ORM\Id]   
    #[ORM\ManyToOne(inversedBy: "carts")]
    #[ORM\JoinColumn(nullable: false, name: "item_id", referencedColumnName: "id")]
    private ?Item $item_id = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: "items")]
    #[ORM\JoinColumn(nullable: false, name: "cart_id", referencedColumnName: "id")]
    private ?Cart $cart_id = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $qty = null;

    public function getItemId(): ?Item
    {
        return $this->item_id;
    }

    public function setItemId(?Item $item_id): self
    {
        $this->item_id = $item_id;

        return $this;
    }

    public function getCartId(): ?Cart
    {
        return $this->cart_id;
    }

    public function setCartId(?Cart $cart_id): self
    {
        $this->cart_id = $cart_id;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }
}
