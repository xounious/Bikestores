<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
/**
 * @ORM\Entity
 * @ORM\Table(name="stocks")
 */
class Stocks implements JsonSerializable {
    /**
     * @ORM\ReturnTypeWillChange
     */
    public function jsonSerialize(): array {
        return [
            'stock_id' => $this->getStock_id(),
            'store_id' => $this->getStore_id(),
            'product_id' => $this->getProduct_id(),
            'quantity' => $this->getQuantity()
        ];
    }

    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $stock_id;

    /** @var int */
    /**
     * @ORM\Column(type="integer")
     */
    private int $store_id;

    /** @var int */
    /**
     * @ORM\Column(type="integer")
     */
    private int $product_id;

    /** @var int */
    /**
     * @ORM\Column(type="integer")
     */
    private int $quantity;

    /**
     * Get stock_id
     * 
     * @return int
     */
    public function getStock_id(): int {
        return $this->stock_id;
    }

    /**
     * Set stock_id
     * 
     * @param int $stock_id
     */
    public function setStock_id(int $stock_id): void {
        $this->stock_id = $stock_id;
    }

    /**
     * Get store_id
     * 
     * @return int
     */
    public function getStore_id(): int {
        return $this->store_id;
    }

    /**
     * Set store_id
     * 
     * @param int $store_id
     */
    public function setStore_id(int $store_id): void {
        $this->store_id = $store_id;
    }

    /**
     * Get product_id
     * 
     * @return int
     */
    public function getProduct_id(): int {
        return $this->product_id;
    }

    /**
     * Set product_id
     * 
     * @param int $product_id
     */
    public function setProduct_id(int $product_id): void {
        $this->product_id = $product_id;
    }

    /**
     * Get quantity
     * 
     * @return int
     */
    public function getQuantity(): int {
        return $this->quantity;
    }

    /**
     * Set quantity
     * 
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }

//    // Relation ManyToOne avec la table Stores
//     /**
//      * @ORM\ManyToOne(targetEntity="Stores", inversedBy="stocks")
//      * @ORM\JoinColumn(name="store_id", referencedColumnName="store_id")
//      */
//     private $stores;

//     /**
//      * Get store
//      * 
//      * @return mixed
//      */
//     public function getStore() {
//         return $this->stores;
//     }

//     /**
//      * Set store
//      * 
//      * @param mixed $stores
//      */
//     public function setStore($stores) {
//         $this->stores = $stores;
//     }

    // // Relation ManyToOne avec la table Products
    // /**
    //  * @ORM\ManyToOne(targetEntity="Products", inversedBy="stocks")
    //  * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
    //  */
    // private $products;

    // /**
    //  * Get product
    //  * 
    //  * @return mixed
    //  */
    // public function getProduct() {
    //     return $this->products;
    // }

    // /**
    //  * Set product
    //  * 
    //  * @param mixed $products
    //  */
    // public function setProduct($products) {
    //     $this->products = $products;
    // }

    /**
     * Récupère tous les stocks
     * 
     * @return array
     */
    public function getAll(): array {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $stocksRepository = $entityManager->getRepository(Stocks::class);
        return $stocksRepository->findAll();
    }

    /**
     * Récupère un stock à partir de son identifiant
     * 
     * @param int $stock_id
     * @return Stocks|null
     */
    public function getFromId(int $stock_id): ?Stocks {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        return $entityManager->find(Stocks::class, $stock_id);
    }

    /**
     * Ajoute un nouveau stock
     * 
     * @param int $store_id
     * @param int $product_id
     * @param int $quantity
     * @return Stocks
     */
    public function add(int $store_id, int $product_id, int $quantity): Stocks {
        $stock = new Stocks();
        $stock->setStore_id($store_id);
        $stock->setProduct_id($product_id);
        $stock->setQuantity($quantity);

        $entityManager = getEntityManager();
        $entityManager->persist($stock);
        $entityManager->flush();

        return $stock;
    }

    /**
     * Met à jour un stock existant
     * 
     * @param int $stock_id
     * @param int $store_id
     * @param int $product_id
     * @param int $quantity
     * @return Stocks
     */
    public function update(int $stock_id, int $store_id, int $product_id, int $quantity): Stocks {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $stock = $entityManager->find(Stocks::class, $stock_id);

        $stock->setStore_id($store_id);
        $stock->setProduct_id($product_id);
        $stock->setQuantity($quantity);

        $entityManager->flush();

        return $stock;
    }

    /**
     * Supprime un stock existant
     * 
     * @param int $stock_id
     */
    public function remove(int $stock_id): bool {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $stock = $entityManager->find(Stocks::class, $stock_id);

        if ($stock != null) {
            // Suppression du stock de la base de données
            $entityManager->remove($stock);
            $entityManager->flush();
            return true; 
        } else {
            return false;
        }
    }

}
?>
