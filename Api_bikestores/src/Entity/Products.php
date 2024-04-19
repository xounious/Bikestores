<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Products implements JsonSerializable {

    /**
     * @ORM\ReturnTypeWillChange
     */
    public function jsonSerialize(): array {
        return [
            'product_id' => $this->getProduct_id(),
            'product_name' => $this->getProduct_name(),
            'brand_id' => $this->getBrand_id(),
            'category_id' => $this->getCategory_id(),
            'model_year' => $this->getModel_year(),
            'list_price' => $this->getList_price()
        ];
    }
    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $product_id;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $product_name;

    /** @var int */
    /**
     * @ORM\Column(type="integer")
     */
    private int $brand_id;

    /** @var int */
    /**
     * @ORM\Column(type="integer")
     */
    private int $category_id;

    /** @var int */
    /**
     * @ORM\Column(type="smallint")
     */
    private int $model_year;

    /** @var string */
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private string $list_price;

    public function __toString() {
        return "product_id: {$this->product_id}, product_name: {$this->product_name} \n";
    }
    
    // Getters and setters for product_id
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

    // Getters and setters for product_name
    /**
     * Get product_name
     * 
     * @return string
     */
    public function getProduct_name(): string {
        return $this->product_name;
    }

    /**
     * Set product_name
     * 
     * @param string $product_name
     */
    public function setProduct_name(string $product_name): void {
        $this->product_name = $product_name;
    }

    // Getters and setters for brand_id
    /**
     * Get brand_id
     * 
     * @return int
     */
    public function getBrand_id(): int {
        return $this->brand_id;
    }

    /**
     * Set brand_id
     * 
     * @param int $brand_id
     */
    public function setBrand_id(int $brand_id): void {
        $this->brand_id = $brand_id;
    }

    // Getters and setters for category_id
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

    // Getters and setters for model_year
    /**
     * Get model_year
     * 
     * @return int
     */
    public function getModel_year(): int {
        return $this->model_year;
    }

    /**
     * Set model_year
     * 
     * @param int $model_year
     */
    public function setModel_year(int $model_year): void {
        $this->model_year = $model_year;
    }

    // Getters and setters for list_price
    /**
     * Get list_price
     * 
     * @return string
     */
    public function getList_price(): string {
        return $this->list_price;
    }

    /**
     * Set list_price
     * 
     * @param string $list_price
     */
    public function setList_price(string $list_price): void {
        $this->list_price = $list_price;
    }

    // // Relation ManyToOne avec la table Brands
    // /**
    //  * @ORM\ManyToOne(targetEntity="Brands", inversedBy="products")
    //  * @ORM\JoinColumn(name="brand_id", referencedColumnName="brand_id")
    //  */
    // private $brand;

    // /**
    //  * Get brand
    //  * 
    //  * @return mixed
    //  */
    // public function getBrand() {
    //     return $this->brand;
    // }

    // /**
    //  * Set brand
    //  * 
    //  * @param Brands $brand
    //  */
    // public function setBrand($brand) {
    //     $this->brand = $brand;
    // }

    // // Relation ManyToOne avec la table Category
    // /**
    //  * @ORM\ManyToOne(targetEntity="Categories", inversedBy="products")
    //  * @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
    //  */
    // private $category;

    // /**
    //  * Get category
    //  * 
    //  * @return mixed
    //  */
    // public function getCategory() {
    //     return $this->category;
    // }

    // /**
    //  * Set category
    //  * 
    //  * @param Categories $category
    //  */
    // public function setCategory($category) {
    //     $this->category = $category;
    // }

    // // Relation OneToMany inverse avec la table Stock
    // /**
    //  * @ORM\OneToMany(targetEntity="Stocks", mappedBy="products")
    //  */
    // private $stocks;

    // public function __construct() {
    //     $this->stocks = new ArrayCollection();
    // }
    /**
     * Récupère tous les produits
     * 
     * @return array
     */
    public function getAll(): array {
        $entityManager = getEntityManager(); // Récupération de l'entityManager
        $products = $entityManager->getRepository(Products::class)->findAll();
        return $products;
    }

    /**
     * Récupère tous les produits avec une limite
     * 
     * @param int $limit
     * @return array
     */
    public function getAllWithLimit(int $limit): array {
        // Code de récupération de tous les produits avec une limite depuis la base de données
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $products = $entityManager->getRepository(Products::class)->findBy([], null, $limit);
        return $products;
    }

    /**
     * Récupère un produit à partir de son ID
     * 
     * @param int $id
     * @return Products|null
     */
    public function getFromId(int $id): ?Products {
        // Code de récupération d'un produit à partir de son ID depuis la base de données
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $product = $entityManager->getRepository(Products::class)->find($id);
        return $product;
    }

    /**
     * Récupère les produits à partir des IDs de marques
     * 
     * @param array $brandsId
     * @return array
     */
    public function getProductsFromBrandsId(int $brand_id): array {
        // Code de récupération des produits à partir des IDs de marques depuis la base de données
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $products = $entityManager->getRepository(Products::class)->findBy(['brand_id' => $brand_id]);
        return $products;
    }

    /**
     * Récupère les produits à partir des IDs de catégories
     * 
     * @param array $categoriesId
     * @return array
     */
    public function getProductsFromCategoriesId(int $category_id): array {
        // Code de récupération des produits à partir des IDs de catégories depuis la base de données
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $products = $entityManager->getRepository(Products::class)->findBy(['category_id' => $category_id]);
        return $products;
    }

    /**
     * Récupère les produits à partir des années
     * 
     * @param array $years
     * @return array
     */
    public function getProductsFromYears(int $model_year): array {
        // Code de récupération des produits à partir des années depuis la base de données
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $products = $entityManager->getRepository(Products::class)->findBy(['model_year' => $model_year]);
        return $products;
    }

    /**
     * Récupère les produits dans une fourchette de prix
     * 
     * @param float $minPrice
     * @param float $maxPrice
     * @return array
     */
    public function getProductsBetweenPrices(float $minPrice, float $maxPrice): array {
        // Code de récupération des produits dans une fourchette de prix depuis la base de données
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $products = $entityManager->getRepository(Products::class)->createQueryBuilder('p')
            ->where('p.list_price BETWEEN :min AND :max')
            ->setParameter('min', $minPrice)
            ->setParameter('max', $maxPrice)
            ->getQuery()
            ->getResult();
        return $products;
    }

    /**
     * Ajoute un nouveau produit
     * 
     * @param string $product_name
     * @param int $brand
     * @param int $category
     * @param int $model_year
     * @param float $list_price
     * @return Products
     */
    public function add(string $product_name, int $brand_id, int $category_id, int $model_year, float $list_price): Products {
        $product = new Products();
        $product->setProduct_name($product_name);
        $product->setBrand_id($brand_id);
        $product->setCategory_id($category_id);
        $product->setModel_year($model_year);
        $product->setList_price($list_price);

        $entityManager = getEntityManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $product;
    }

    /**
     * Met à jour un produit existant
     * 
     * @param int $product_id
     * @param string $product_name
     * @param int $brand_id
     * @param int $category_id
     * @param int $model_year
     * @param float $list_price
     * @return Products
     */
    public function update(int $product_id, string $product_name, int $brand_id, int $category_id, int $model_year, float $list_price): Products {
        // Récupération du produit à mettre à jour depuis la base de données
        $entityManager = getEntityManager();
        $product = $entityManager->find(Products::class, $product_id);

        // Mise à jour des propriétés du produit
        $product->setProduct_name($product_name);
        $product->setBrand_id($brand_id);
        $product->setCategory_id($category_id);
        $product->setModel_year($model_year);
        $product->setList_price($list_price);

        // Mise à jour du produit dans la base de données
        $entityManager->flush();

        return $product;
    }

    /**
     * Supprime un produit existant
     * 
     * @param int $product_id
     * @return string
     */
    public function remove(int $product_id) {
        // Récupération du produit à supprimer depuis la base de données
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $product = $entityManager->find(Products::class, $product_id);
        if ($product != null) {
           // Suppression du produit de la base de données
           $stocks = $entityManager->getRepository(Stocks::class)->findBy(['product_id' => $product_id]);
            if (!empty($stocks)) {
                foreach ($stocks as $stock) {
                    $object = new Stocks();
                    $object->remove($stock->getStock_id());
                }
            }
            $entityManager->remove($product);
            $entityManager->flush();
            return true; 
        } else {
            return false;
        } 
    }
}
