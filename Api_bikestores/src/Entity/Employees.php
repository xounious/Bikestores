<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
/**
 * @ORM\Entity
 * @ORM\Table(name="employees")
 */
class Employees implements JsonSerializable {
    /**
     * @ORM\ReturnTypeWillChange
     */
    public function jsonSerialize(): array {
        return [
            'employee_id' => $this->getEmployee_id(),
            'store_id' => $this->getStore_id(),
            'employee_name' => $this->getEmployee_name(),
            'employee_email' => $this->getEmployee_email(),
            'employee_password' => '',
            'employee_role' => $this->getEmployee_role()
        ];
    }

    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $employee_id;

    /** @var int */
    /**
     * @ORM\Column(type="integer")
     */
    private int $store_id;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $employee_name;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $employee_email;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $employee_password;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $employee_role;

    /**
     * Get employee_id
     * 
     * @return int
     */
    public function getEmployee_id(): int {
        return $this->employee_id;
    }

    /**
     * Set employee_id
     * 
     * @param int $employee_id
     */
    public function setEmployee_id(int $employee_id): void {
        $this->employee_id = $employee_id;
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
     * Get employee_name
     * 
     * @return string
     */
    public function getEmployee_name(): string {
        return $this->employee_name;
    }

    /**
     * Set employee_name
     * 
     * @param string $employee_name
     */
    public function setEmployee_name(string $employee_name): void {
        $this->employee_name = $employee_name;
    }

    /**
     * Get employee_email
     * 
     * @return string
     */
    public function getEmployee_email(): string {
        return $this->employee_email;
    }

    /**
     * Set employee_email
     * 
     * @param string $employee_email
     */
    public function setEmployee_email(string $employee_email): void {
        $this->employee_email = $employee_email;
    }

    /**
     * Get employee_password
     * 
     * @return string
     */
    public function getEmployee_password(): string {
        return $this->employee_password;
    }

    /**
     * Set employee_password
     * 
     * @param string $employee_password
     */
    public function setEmployee_password(string $employee_password): void {
        $this->employee_password = $employee_password;
    }

    /**
     * Get employee_role
     * 
     * @return string
     */
    public function getEmployee_role(): string {
        return $this->employee_role;
    }

    /**
     * Set employee_role
     * 
     * @param string $employee_role
     */
    public function setEmployee_role(string $employee_role): void {
        $this->employee_role = $employee_role;
    }

    /**
     * Récupère un employee à partir de son ID
     * 
     * @param int $id
     * @return Employees|null 
     */
    public function getFromId(int $id): ?Employees {
        // Code de récupération d'un employee à partir de son ID depuis la base de données
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $product = $entityManager->getRepository(Employees::class)->find($id);
        return $product;
    }

    // // Relation ManyToOne avec la table Stores
    // /**
    //  * @ORM\ManyToOne(targetEntity="Stores", inversedBy="employees")
    //  * @ORM\JoinColumn(name="store_id", referencedColumnName="store_id")
    //  */
    // private $stores;

    // public function getStore() {
    //     return $this->stores;
    // }

    // public function setStore($store) {
    //     $this->stores = $stores;
    // }

    /**
     * Supprime un employee existant
     * 
     * @param int $employee_id
     */
    public function remove(int $employee_id): bool {
        $entityManager = getEntityManager(); // fonction de récupération de l'entityManager
        $employee = $entityManager->find(Employees::class, $employee_id);

        if ($employee != null) {
            $entityManager->remove($employee);
            $entityManager->flush();
            return true; 
        } else {
            return false;
        }
    }

    /**
     * Recherche un employé par email et mot de passe
     * 
     * @param string $email
     * @param string $password
     * @return Employees|null
     */
    public function search(string $email, string $password): ?Employees {
        $entityManager = getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('e')
                    ->from(Employees::class, 'e')
                    ->where('e.employee_email = :email')
                    ->andWhere('e.employee_password = :password')
                    ->setParameter('email', $email)
                    ->setParameter('password', $password);

        $query = $queryBuilder->getQuery();
        $result = $query->getResult();

        if (!empty($result)) {
            return $result[0]; // Si un employé correspondant est trouvé, retournez-le
        } else {
            return null; // Sinon, retournez null
        }
    }

    /**
     * Modifie les informations d'un employé
     * 
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function modifierInformations(int $id, int $store_id, string $name, string $email, string $password, string $role): void {
        $entityManager = getEntityManager();
        $employee = $entityManager->find(Employees::class, $id);

        if ($employee !== null) {
            // Si l'employé est trouvé, mettez à jour ses informations
            $employee->setStore_id($store_id);
            $employee->setEmployee_name($name);
            $employee->setEmployee_email($email);
            $employee->setEmployee_password($password);
            $employee->setEmployee_role($role);

            // Enregistrez les modifications dans la base de données
            $entityManager->flush();
        }
    }
}
?>
