<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
/**
 * @ORM\Entity
 * @ORM\Table(name="brands")
 */
class Brands implements JsonSerializable {

    /**
     * @ORM\ReturnTypeWillChange
     */
    public function jsonSerialize(): array {
        return [
            'brand_id' => $this->getBrand_id(),
            'brand_name' => $this->getBrand_name()
        ];
    }

    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $brand_id;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $brand_name;

    public function __toString() {
        return "brand_id: {$this->brand_id}, brand_name: {$this->brand_name} \n";
    }
    /**
     * Get brand_id
     */
    public function getBrand_id() {
        return $this->brand_id;
    }
    /**
     * Get brand_name
     */
    public function getBrand_name() {
        return $this->brand_name;
    }
    
    /**
     * Set brand_id
     * 
     * @param int $brand_id
     */
    public function setBrand_id($brand_id) {
        $this->brand_id = $brand_id;
    }
    /**
     * Set brand_name
     * 
     * @param string $brand_name
     */
    public function setBrand_name($brand_name) {
        $this->brand_name = $brand_name;
    }

    // // Relation OneToMany avec la table Products
    // /**
    //  * @ORM\OneToMany(targetEntity="Products", mappedBy="brand")
    //  */
    // private $products;

    // public function __construct() {
    //     $this->products = new ArrayCollection();
    // }

    // /**
    //  * @return Collection|Products[]
    //  */
    // public function getProducts() {
    //     return $this->products;
    // }

    // public function addProduct(Products $product) {
    //     if (!$this->products->contains($product)) {
    //         $this->products[] = $product;
    //         $product->setBrand($this);
    //     }
    // }

    // public function removeProduct(Products $product) {
    //     if ($this->products->contains($product)) {
    //         $this->products->removeElement($product);
    //         // set the owning side to null (unless already changed)
    //         if ($product->getBrand() === $this) {
    //             $product->setBrand(null);
    //         }
    //     }
    // }
    /**
     * Récupère toutes les marques
     * 
     * @return array
     */
    public function getAll(): array {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $brandsRepository = $entityManager->getRepository(Brands::class);
        return $brandsRepository->findAll();
    }

    /**
     * Récupère une marque à partir de son identifiant
     * 
     * @param int $brand_id
     * @return Brands|null
     */
    public function getFromId(int $brand_id): ?Brands {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        return $entityManager->find(Brands::class, $brand_id);
    }

    /**
     * Ajoute une nouvelle marque
     * 
     * @param string $brand_name
     * @return Brands
     */
    public function add(string $brand_name): Brands {
        $brand = new Brands();
        $brand->setBrand_name($brand_name);

        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $entityManager->persist($brand);
        $entityManager->flush();

        return $brand;
    }

    /**
     * Met à jour une marque existante
     * 
     * @param int $brand_id
     * @param string $brand_name
     * @return Brands
     */
    public function update(int $brand_id, string $brand_name): Brands {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $brand = $entityManager->find(Brands::class, $brand_id);

        $brand->setBrand_name($brand_name);

        $entityManager->flush();

        return $brand;
    }

    /**
     * Supprime une marque existante
     * 
     * @param int $brand_id
     * @return string
     */
    public function remove(int $brand_id) {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $brand = $entityManager->find(Brands::class, $brand_id);
        
        if ($brand != null) {
            // Suppression de la marque de la base de données
            $products = $entityManager->getRepository(Products::class)->findBy(['brand_id' => $brand_id]);
            if (!empty($products)) {
                foreach ($products as $product) {
                    $object = new Products();
                    $object->remove($product->getProduct_id());
                }
            }
            $entityManager->remove($brand);
            $entityManager->flush();
            return true; 
        } else {
            return false;
        }
    }

}
?>
