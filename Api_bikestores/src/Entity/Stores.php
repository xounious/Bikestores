<?php
namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="stores")
 */
class Stores implements JsonSerializable {
    /**
     * @ORM\ReturnTypeWillChange
     */
    public function jsonSerialize(): array {
        return [
            'store_id' => $this->getStore_id(),
            'store_name' => $this->getStore_name(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'street' => $this->getStreet(),
            'city' => $this->getCity(),
            'state' => $this->getState(),
            'zip_code' => $this->getZip_code()
        ];
    }

    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $store_id;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $store_name;

    /** @var string */
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $phone;

    /** @var string */
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $email;

    /** @var string */
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $street;

    /** @var string */
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $city;

    /** @var string */
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $state;

    /** @var string */
    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private ?string $zip_code;

    public function __toString() {
        return "store_id: {$this->store_id}, store_name: {$this->store_name} \n";
    }
    
    // Getters and setters for store_id
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

    // Getters and setters for store_name
    /**
     * Get store_name
     * 
     * @return string
     */
    public function getStore_name(): string {
        return $this->store_name;
    }

    /**
     * Set store_name
     * 
     * @param string $store_name
     */
    public function setStore_name(string $store_name): void {
        $this->store_name = $store_name;
    }

    // Getters and setters for phone
    /**
     * Get phone
     * 
     * @return string|null
     */
    public function getPhone(): ?string {
        return $this->phone;
    }

    /**
     * Set phone
     * 
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void {
        $this->phone = $phone;
    }

    // Getters and setters for email
    /**
     * Get email
     * 
     * @return string|null
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * Set email
     * 
     * @param string|null $email
     */
    public function setEmail(?string $email): void {
        $this->email = $email;
    }

    // Getters and setters for street
    /**
     * Get street
     * 
     * @return string|null
     */
    public function getStreet(): ?string {
        return $this->street;
    }

    /**
     * Set street
     * 
     * @param string|null $street
     */
    public function setStreet(?string $street): void {
        $this->street = $street;
    }

    // Getters and setters for city
    /**
     * Get city
     * 
     * @return string|null
     */
    public function getCity(): ?string {
        return $this->city;
    }

    /**
     * Set city
     * 
     * @param string|null $city
     */
    public function setCity(?string $city): void {
        $this->city = $city;
    }

    // Getters and setters for state
    /**
     * Get state
     * 
     * @return string|null
     */
    public function getState(): ?string {
        return $this->state;
    }

    /**
     * Set state
     * 
     * @param string|null $state
     */
    public function setState(?string $state): void {
        $this->state = $state;
    }

    // Getters and setters for zip_code
    /**
     * Get zip_code
     * 
     * @return string|null
     */
    public function getZip_code(): ?string {
        return $this->zip_code;
    }

    /**
     * Set zip_code
     * 
     * @param string|null $zip_code
     */
    public function setZip_code(?string $zip_code): void {
        $this->zip_code = $zip_code;
    }

    // Relation OneToMany avec la table Employee
    /**
     * @ORM\OneToMany(targetEntity="Employees", mappedBy="stores")
     */
    private $employees;

    public function __construct() {
        $this->employees = new ArrayCollection();
    }

    // /**
    //  * @return Collection|Employees[]
    //  */
    // static public function getEmployees() {
    //     return $this->employees;
    // }

    // static public function addEmployee(Employees $employee) {
    //     if (!$this->employees->contains($employee)) {
    //         $this->employees[] = $employee;
    //         $employee->setStore($this);
    //     }
    // }

    // static public function removeEmployee(Employees $employee) {
    //     if ($this->employees->contains($employee)) {
    //         $this->employees->removeElement($employee);
    //         if ($employee->getStore() === $this) {
    //             $employee->setStore(null);
    //         }
    //     }
    // }


    // Relation OneToMany avec la table Stock
    /**
     * @ORM\OneToMany(targetEntity="Stocks", mappedBy="stores")
     */
    // private $stocks;

    // /**
    //  * @return Collection|Stocks[]
    //  */
    // static public function getStocks() {
    //     return $this->stocks;
    // }

    // static public function addStock(Stocks $stock) {
    //     if (!$this->stocks->contains($stock)) {
    //         $this->stocks[] = $stock;
    //         $stock->setStore($this);
    //     }
    // }

    // static public function removeStock(Stocks $stock) {
    //     if ($this->stocks->contains($stock)) {
    //         $this->stocks->removeElement($stock);
    //         if ($stock->getStore() === $this) {
    //             $stock->setStore(null);
    //         }
    //     }
    // }

    /**
     * Récupère tous les magasins
     * 
     * @return array
     */
    public function getAll(): array {
        $entityManager = getEntityManager();
        $storesRepository = $entityManager->getRepository(Stores::class);
        return $storesRepository->findAll();
    }

    /**
     * Récupère un magasin à partir de son identifiant
     * 
     * @param int $store_id
     * @return Stores|null
     */
    public function getFromId(int $store_id): ?Stores {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        return $entityManager->find(Stores::class, $store_id);
    }

    /**
     * Ajoute un nouveau magasin
     * 
     * @param string $store_name
     * @param string|null $phone
     * @param string|null $email
     * @param string|null $street
     * @param string|null $city
     * @param string|null $state
     * @param string|null $zip_code
     * @return Stores
     */
    public function add(string $store_name, ?string $phone, ?string $email, ?string $street, ?string $city, ?string $state, ?string $zip_code): Stores {
        $store = new Stores();
        $store->setStore_name($store_name);
        $store->setPhone($phone);
        $store->setEmail($email);
        $store->setStreet($street);
        $store->setCity($city);
        $store->setState($state);
        $store->setZip_code($zip_code);

        $entityManager = getEntityManager();
        $entityManager->persist($store);
        $entityManager->flush();

        return $store;
    }

    /**
     * Met à jour un magasin existant
     * 
     * @param int $store_id
     * @param string $store_name
     * @param string|null $phone
     * @param string|null $email
     * @param string|null $street
     * @param string|null $city
     * @param string|null $state
     * @param string|null $zip_code
     * @return Stores
     */
    public function update(int $store_id, string $store_name, ?string $phone, ?string $email, ?string $street, ?string $city, ?string $state, ?string $zip_code): Stores {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $store = $entityManager->find(Stores::class, $store_id);

        $store->setStore_name($store_name);
        $store->setPhone($phone);
        $store->setEmail($email);
        $store->setStreet($street);
        $store->setCity($city);
        $store->setState($state);
        $store->setZip_code($zip_code);

        $entityManager->flush();

        return $store;
    }

    /**
     * Supprime un magasin existant
     * 
     * @param int $store_id
     */
    public function remove(int $store_id) {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $store = $entityManager->find(Stores::class, $store_id);

        if ($store != null) {
            // Suppression du magasin de la base de données
            $stocks = $entityManager->getRepository(Stocks::class)->findBy(['store_id' => $store_id]);
            if (!empty($stocks)) {
                foreach ($stocks as $stock) {
                    $object = new Stocks();
                    $object->remove($stock->getStock_id());
                }
            }
            $employees = $entityManager->getRepository(Employees::class)->findBy(['store_id' => $store_id]);
            // return $employees;
            if (!empty($employees)) {
                foreach ($employees as $employee) {
                    $object = new Employees();
                    $object->remove($employee->getEmployee_id());
                }
            }
            $entityManager->remove($store);
            $entityManager->flush();
            return true; 
        } else {
            return false;
        }
    }

    /**
     * Récupère tous les employés d'un magasin
     * 
     * @param int $store_id
     * @return array
     */
    public function getAllEmployeesFromStore(int $store_id): array {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $employees = $entityManager->getRepository(Employees::class)->findBy(array('store_id' => $store_id)); 
        return $employees;
    }

    /**
     * Récupère tous les employés de tous les magasins
     * 
     * @return array
     */
    public function getAllEmployeesFromAllStores(): array {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $employees = $entityManager->getRepository(Employees::class)->findAll(); 
        return $employees;
    }
}

