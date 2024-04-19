<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Categories implements JsonSerializable {
    /**
     * @ORM\ReturnTypeWillChange
     */
    public function jsonSerialize(): array {
        return [
            'category_id' => $this->getCategory_id(),
            'category_name' => $this->getCategory_name()
        ];
    }

    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $category_id;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $category_name;

    /**
     * Get category_id
     * 
     * @return int
     */
    public function getCategory_id(): int {
        return $this->category_id;
    }

    /**
     * Set category_id
     * 
     * @param int $category_id
     */
    public function setCategory_id(int $category_id): void {
        $this->category_id = $category_id;
    }

    /**
     * Get category_name
     * 
     * @return string
     */
    public function getCategory_name(): string {
        return $this->category_name;
    }

    /**
     * Set category_name
     * 
     * @param string $category_name
     */
    public function setCategory_name(string $category_name): void {
        $this->category_name = $category_name;
    }

    // // Relation OneToMany avec la table Products
    // /**
    //  * @ORM\OneToMany(targetEntity="Products", mappedBy="category")
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

    // /**
    //  * Add product
    //  * 
    //  * @param Products $product
    //  */
    // public function addProduct(Products $product) {
    //     if (!$this->products->contains($product)) {
    //         $this->products[] = $product;
    //         $product->setCategory($this);
    //     }
    // }

    // /**
    //  * Remove product
    //  * 
    //  * @param Products $product
    //  */
    // public function removeProduct(Products $product) {
    //     if ($this->products->contains($product)) {
    //         $this->products->removeElement($product);
    //         // set the owning side to null (unless already changed)
    //         if ($product->getCategory() === $this) {
    //             $product->setCategory(null);
    //         }
    //     }
    // }

    /**
     * Récupère toutes les catégories
     * 
     * @return array
     */
    public function getAll(): array {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $categoriesRepository = $entityManager->getRepository(Categories::class);
        return $categoriesRepository->findAll();
    }

    /**
     * Récupère une catégorie à partir de son identifiant
     * 
     * @param int $category_id
     * @return Categories|null
     */
    public function getFromId(int $category_id): ?Categories {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        return $entityManager->find(Categories::class, $category_id);
    }

    /**
     * Ajoute une nouvelle catégorie
     * 
     * @param string $category_name
     * @return Categories
     */
    public function add(string $category_name): Categories {
        $category = new Categories();
        $category->setCategory_name($category_name);

        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $entityManager->persist($category);
        $entityManager->flush();

        return $category;
    }

    /**
     * Met à jour une catégorie existante
     * 
     * @param int $category_id
     * @param string $category_name
     * @return Categories
     */
    public function update(int $category_id, string $category_name): Categories {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $category = $entityManager->find(Categories::class, $category_id);

        $category->setCategory_name($category_name);
        $entityManager->flush();

        return $category;
    }

    /**
     * Supprime une catégorie existante
     * 
     * @param int $category_id
     */
    public function remove(int $category_id): bool {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $category = $entityManager->find(Categories::class, $category_id);

        if ($category != null) {
            // Suppression de la categorie de la base de données
            $products = $entityManager->getRepository(Products::class)->findBy(['category_id' => $category_id]);
            if (!empty($products)) {
                foreach ($products as $product) {
                    $object = new Products();
                    $object->remove($product->getProduct_id());
                }
            }
            $entityManager->remove($category);
            $entityManager->flush();
            return true; 
        } else {
            return false;
        }
    }
}
?>
