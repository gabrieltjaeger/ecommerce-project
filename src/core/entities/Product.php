<?php
namespace src\core\entities;

use src\core\entities\Entity;

class Product extends Entity
{
  private ?string $product = null;
  private ?string $price = null;
  private ?string $width = null;
  private ?string $height = null;
  private ?string $length = null;
  private ?string $weight = null;
  private ?string $url = null;

  public function __construct(
    ?string $id = null,
    ?string $product = null,
    ?string $price = null,
    ?string $width = null,
    ?string $height = null,
    ?string $length = null,
    ?string $weight = null,
    ?string $url = null,
    ?string $created_at = null,
    ?string $updated_at = null
  ) {
    parent::__construct($id, $created_at, $updated_at);
    $this->product = $product;
    $this->price = $price;
    $this->width = $width;
    $this->height = $height;
    $this->length = $length;
    $this->weight = $weight;
    $this->url = $url;
  }

  public function getProduct(): ?string
  {
    return $this->product;
  }

  public function getPrice(): ?string
  {
    return $this->price;
  }

  public function getWidth(): ?string
  {
    return $this->width;
  }

  public function getHeight(): ?string
  {
    return $this->height;
  }

  public function getLength(): ?string
  {
    return $this->length;
  }

  public function getWeight(): ?string
  {
    return $this->weight;
  }

  public function getUrl(): ?string
  {
    return $this->url;
  }

  public function setProduct(string $product): void
  {
    $this->product = $product;
  }

  public function setPrice(string $price): void
  {
    $this->price = $price;
  }

  public function setWidth(string $width): void
  {
    $this->width = $width;
  }

  public function setHeight(string $height): void
  {
    $this->height = $height;
  }

  public function setLength(string $length): void
  {
    $this->length = $length;
  }

  public function setWeight(string $weight): void
  {
    $this->weight = $weight;
  }

  public function setUrl(string $url): void
  {
    $this->url = $url;
  }

}

?>