<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

require __DIR__ . '/bootstrap.php';

use Entity\Products;
use Entity\Employees;
use Entity\Stocks;
use Entity\Stores;
use Entity\Brands;
use Entity\Categories;

if (isset($_GET)) {
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $key = isset($_GET['key']) ? $_GET['key'] : null;
    $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 1000;
}
if (isset($_POST)) {
    $bodyData = json_decode(file_get_contents('php://input'), true);
}
if ($key == 'e8f1997c763') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($action === 'products') {
            $object = new Products();
            if ($id == null) {
                if ($filter != null) {
                    if ($filter == 'price') {
                        if (isset($_GET['min']) and isset($_GET['max'])) {
                            $json = $object->getProductsBetweenPrices($_GET['min'], $_GET['max']);
                        }
                        if ($json) {
                            http_response_code(200);
                            echo json_encode($json);
                        } else {
                            http_response_code(404);
                            echo json_encode(array("message" => "No products Found with filter"));
                        }
                    }
                } else {
                    $json = $object->getAllWithLimit($limit);
                    if ($json) {
                        http_response_code(200);
                        echo json_encode($json);
                    } else {
                        http_response_code(404);
                        echo json_encode(array("message" => "No products Found"));
                    } 
                }
                
            } else {
                if ($filter != null) {
                    $json = null;
                    if ($filter == 'years') {
                        $json = $object->getProductsFromYears($id);
                    } else if ($filter == 'categories') {
                        $json = $object->getProductsFromCategoriesId($id);
                    } else if ($filter == 'brands') {
                        $json = $object->getProductsFromBrandsId($id);
                    }
                    if ($json) {
                        http_response_code(200);
                        echo json_encode($json);
                    } else {
                        http_response_code(404);
                        echo json_encode(array("message" => "No products Found with filter"));
                    }
                } else {
                    $json = $object->getFromId($id);
                    if ($json) {
                        http_response_code(200);
                        echo json_encode($json);
                    } else {
                        http_response_code(404);
                        echo json_encode(array("message" => "No products Found for id : ".$id));
                    }
                }
                
            }
        } else if ($action === 'brands') {
            $object = new Brands();
            if ($id != null) {
                $json = $object->getFromId($id);
                if ($json) {
                    http_response_code(200);
                    echo json_encode($json);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No brands Found"));
                }
            } else {
                $json = $object->getAll();
                if ($json) {
                    http_response_code(200);
                    echo json_encode($json);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No brands Found"));
                }
            }
        } else if ($action === 'categories') {
            $object = new Categories();
            if ($id != null) {
                $json = $object->getFromId($id);
                if ($json) {
                    http_response_code(200);
                    echo json_encode($json);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No Categories Found"));
                }
            } else {
                $json = $object->getAll();
                if ($json) {
                    http_response_code(200);
                    echo json_encode($json);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No Categories Found"));
                }
            }
        } else if ($action === 'stores') {
            $object = new Stores();
            if ($id != null) {
                $json = $object->getFromId($id);
                if ($json) {
                    http_response_code(200);
                    echo json_encode($json);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No Stores Found"));
                }
            } else {
                $json = $object->getAll();
                if ($json) {
                    http_response_code(200);
                    echo json_encode($json);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No Stores Found"));
                }
            }
        } else if ($action === 'employees') {
            $object = new Employees();
            if ($id != null) {
                $json = $object->getFromId($id);
                if ($json) {
                    http_response_code(200);
                    echo json_encode($json);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No Stores Found"));
                }
            } else {
                $json = $object->getAll();
                if ($json) {
                    http_response_code(200);
                    echo json_encode($json);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No Stores Found"));
                }
            }
        } else if ($action === 'employeesStore') {
            $object = new Stores();
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            if ($id != null) {
                $json = $object->getAllEmployeesFromStore($id);
                if ($json) {
                    http_response_code(200);
                    echo json_encode($json);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No employees found for store with id : "+$id));
                }
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "No id Store found in the url"));
            }
            
        } else if ($action === 'employeesStores') {
            $object = new Stores();
            $json = $object->getAllEmployeesFromAllStores();
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Aucun produit trouvé."));
            }
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Action non valide pour GET."));
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($action === 'products') {
            $object = new Products();
            $json = $object->add($bodyData['product_name'], $bodyData['brand_id'], $bodyData['category_id'], $bodyData['model_year'], $bodyData['list_price']);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Insertion of Product Failed"));
            }
        } else if ($action === 'brands') {
            $object = new Brands();
            $json = $object->add($bodyData['brand_name']);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Insertion of Brand Failed"));
            }
        } else if ($action === 'categories') {
            $object = new Categories();
            $json = $object->add($bodyData['category_name']);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Insertion of Category Failed"));
            }
        } else if ($action === 'stocks') {
            $object = new Stocks();
            $json = $object->add($bodyData['store_id'], $bodyData['product_id'], $bodyData['quantity']);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Insertion of Stock Failed"));
            }
        } else if ($action === 'stores') {
            $object = new Stores();
            $json = $object->add($bodyData['store_name'], $bodyData['phone'], $bodyData['email'], $bodyData['street'], $bodyData['city'], $bodyData['state'], $bodyData['zip_code']);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Insertion of Store Failed"));
            }
        } else if ($action === 'searchEmployee') {
            $object = new Employees();
            $json = $object->search($bodyData['employee_email'], $bodyData['employee_password']);
            http_response_code(200);
            echo json_encode($json);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Action non valide pour POST."));
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        if ($action === 'products' and $id != null) {
            $object = new Products();
            $json = $object->update($id, $bodyData['product_name'], $bodyData['brand_id'], $bodyData['category_id'], $bodyData['model_year'], $bodyData['list_price']);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Update of Product Failed"));
            }
        } else if ($action === 'brands' and $id != null) {
            $object = new Brands();
            $json = $object->update($id, $bodyData['brand_name']);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Update of Brand Failed"));
            }
        } else if ($action === 'categories' and $id != null) {
            $object = new Categories();
            $json = $object->update($id, $bodyData['category_name']);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Update of Category Failed"));
            }
        } else if ($action === 'stocks' and $id != null) {
            $object = new Stocks();
            $json = $object->update($id, $bodyData['store_id'], $bodyData['product_id'], $bodyData['quantity']);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Update of Stock Failed"));
            }
        } else if ($action === 'stores' and $id != null) {
            $object = new Stores();
            $json = $object->update($id, $bodyData['store_name'], $bodyData['phone'], $bodyData['email'], $bodyData['street'], $bodyData['city'], $bodyData['state'], $bodyData['zip_code']);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Update of Store Failed"));
            }
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Action non valide ou id non précisé pour PUT"));
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        if ($action === 'products' and $id !== null) {
            $object = new Products();
            $json = $object->remove($id);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Delete of Product Failed, incorrect id"));
            }
        } else if ($action === 'brands' and $id !== null) {
            $object = new Brands();
            $json = $object->remove($id);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Delete of Brand Failed, incorrect id"));
            }
        } else if ($action === 'categories' and $id != null) {
            $object = new Categories();
            $json = $object->remove($id);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Delete of Category Failed, incorrect id"));
            }
        } else if ($action === 'stocks' and $id != null) {
            $object = new Stocks();
            $json = $object->remove($id);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Delete of Stock Failed, incorrect id"));
            }
        } else if ($action === 'stores' and $id != null) {
            $object = new Stores();
            $json = $object->remove($id);
            if ($json) {
                http_response_code(200);
                echo json_encode($json);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Delete of Store Failed, incorrect id"));
            }
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Action non valide ou id non précisé pour DELETE"));
        }
    }
} else if ($key == null) {
    http_response_code(200);
    echo json_encode('page index');
}
?>
