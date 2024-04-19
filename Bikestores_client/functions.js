// Fonction pour initialiser la carte OpenStreetMap
function initMap() {
    var map = L.map('map').setView([0, 0], 13); // Initialiser la carte avec un centre par défaut et un niveau de zoom

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Appeler la fonction pour récupérer la position de l'utilisateur
    getUserLocation(map);
}

// Fonction pour récupérer la position de l'utilisateur à partir de son adresse IP
function getUserLocation(map) {
    fetch('https://api.bigdatacloud.net/data/ip-geolocation?key=bdc_747efc99fc704dcfaff12fe00d72dc77')
        .then(response => response.json())
        .then(data => {
            var lat = data.location.latitude;
            var lon = data.location.longitude;

            // Localiser la carte sur la position de l'utilisateur
            map.setView([lat, lon], 13);
            L.marker([lat, lon]).addTo(map); // Ajouter un marqueur à la position de l'utilisateur
        })
        .catch(error => {
            console.error('Error fetching user location:', error);
        });
}

// Function to fetch data from API
function fetchData(tabId) {
    // Fetch data based on tabId
    let url;
    if (tabId == 'products') {
        url = 'https://dev-vallee211.users.info.unicaen.fr/bikestores/products?key=e8f1997c763';
    } else if (tabId == 'brands') {
        url = 'https://dev-vallee211.users.info.unicaen.fr/bikestores/brands?key=e8f1997c763';
    } else if (tabId == 'categories') {
        url = 'https://dev-vallee211.users.info.unicaen.fr/bikestores/categories?key=e8f1997c763';
    } else if (tabId == 'stores') {
        url = 'https://dev-vallee211.users.info.unicaen.fr/bikestores/stores?key=e8f1997c763';
    } else {
        return;
    }
    fetch(url, {
        method: "GET",
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(response.message);
        }
        return response.json();
    })
    .then(data => {
      // Once data is fetched, fill the table with the data
      fillTable(tabId, data);
    }).catch(error => {
      console.error('Error fetching data:', error);
    });
}

// Function to fill the table with data
function fillTable(tabId, data) {
    // Get the container for the table
    const container = document.getElementById(tabId);

    // Clear previous content
    container.innerHTML = '';

    // Create a table element
    const table = document.createElement('table');
    table.classList.add('table', 'table-striped');

    // Create table header row
    const headerRow = document.createElement('tr');
    for (const key in data[0]) {
    const th = document.createElement('th');
    if (key.includes('_')) {
        let baseName = key.split("_")[1];
        th.textContent = baseName[0].toUpperCase() + baseName.slice(1);
        if (th.textContent == 'Id') {
            th.textContent += " " + key.split("_")[0];
        }
    } else {
        th.textContent = key[0].toUpperCase() + key.slice(1); 
    }
    
    headerRow.appendChild(th);
    }
    table.appendChild(headerRow);

    // Create table body rows
    data.forEach(item => {
    const row = document.createElement('tr');
    for (const key in item) {
        const cell = document.createElement('td');
        cell.textContent = item[key];
        row.appendChild(cell);
    }
    table.appendChild(row);
    });

    // Append the table to the container
    container.appendChild(table);
}

// cherche si les identifiants correspondent dans la bdd
function login() {
    // Récupération des valeurs des champs email et mot de passe
    var email = document.getElementById("inputEmail").value;
    var password = document.getElementById("inputPassword").value;
    console.log(email);
    console.log(password);

    // Appel au web service pour l'authentification
    fetch('https://dev-vallee211.users.info.unicaen.fr/bikestores/employee/search?key=e8f1997c763', {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            employee_email: email,
            employee_password: password
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(response.message);
        }
        return response.json();
    })
    .then(data => {
        // Vérification de la réponse du web service
        if (data !== null) {
            // L'authentification est réussie, ajout des informations aux cookies
            document.cookie = "employee_id=" + data.employee_id + "; path=/";
            document.cookie = "employee_role=" + data.employee_role + "; path=/";

            // Redirection vers la page d'accueil
            document.querySelector('#infosConnexion').innerText = "access granted, good day "+data.employee_name+" !";
            document.querySelector('#infosConnexion').style.color = "darkgreen";
        } else {
            // Affichage d'un message d'erreur
            document.querySelector('#infosConnexion').innerText = "unrecognized credits, please try again.";
            document.querySelector('#infosConnexion').style.color = "red";
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred. Please try again later.");
    });
}

// Fonction pour afficher/cacher les filtres avec une transition
function toggleFilters() {
    var filtersContainer = document.getElementById("filtersContainer");
    if (filtersContainer.style.display === "none") {
        filtersContainer.style.display = "block";
        filtersContainer.style.transition = "display 0.5s ease";
    } else {
        filtersContainer.style.display = "none";
    }
}

// Fonction pour récupérer les marques (brands) depuis le web service
function fetchBrands() {
    fetch('https://dev-vallee211.users.info.unicaen.fr/bikestores/brands?key=e8f1997c763', {method: "GET"})
    .then(response => response.json())
    .then(data => {
        // Ajouter les options des marques dans la div de filtre correspondante
        var brandsDiv = document.querySelector('#divFilterBrands');
        data.forEach(brand => {
            var checkbox = document.createElement('input');
            checkbox.type = "checkbox";
            checkbox.name = "brand";
            checkbox.value = brand.brand_id;
            checkbox.id = "brand_" + brand.brand_id;
            var label = document.createElement('label');
            label.htmlFor = "brand_" + brand.brand_id;
            label.appendChild(document.createTextNode(brand.brand_name));
            brandsDiv.appendChild(checkbox);
            brandsDiv.appendChild(label);
            brandsDiv.appendChild(document.createElement('br'));
        });
    })
    .catch(error => console.error('Error:', error));
}

// Fonction pour récupérer les catégories depuis le web service
function fetchCategories() {
    fetch('https://dev-vallee211.users.info.unicaen.fr/bikestores/categories?key=e8f1997c763', {method: "GET"})
    .then(response => response.json())
    .then(data => {
        // Ajouter les options des catégories dans la div de filtre correspondante
        var categoriesDiv = document.querySelector('#divFilterCategories');
        data.forEach(category => {
            var checkbox = document.createElement('input');
            checkbox.type = "checkbox";
            checkbox.name = "category";
            checkbox.value = category.category_id;
            checkbox.id = "category_" + category.category_id;
            var label = document.createElement('label');
            label.htmlFor = "category_" + category.category_id;
            label.appendChild(document.createTextNode(category.category_name));
            categoriesDiv.appendChild(checkbox);
            categoriesDiv.appendChild(label);
            categoriesDiv.appendChild(document.createElement('br'));
        });
    })
    .catch(error => console.error('Error:', error));
}

// Fonction pour appliquer les filtres 
async function applyFilters() {
    // Récupérer les valeurs des filtres
    let selectedYears = [...document.querySelectorAll('input[name="year"]:checked')].map(checkbox => checkbox.value);
    let selectedBrands = [...document.querySelectorAll('input[name="brand"]:checked')].map(checkbox => checkbox.value);
    let selectedCategories = [...document.querySelectorAll('input[name="category"]:checked')].map(checkbox => checkbox.value);
    let minPrice = document.getElementById('minPrice').value;
    let maxPrice = document.getElementById('maxPrice').value;

    // Effectuer les requêtes pour chaque filtre et récupérer les produits correspondants
    let filteredProductsByYear;
    let filteredProductsByBrand;
    let filteredProductsByCategory;

    if (selectedYears.length == 0) {
        filteredProductsByYear = await getAllProducts();
    } else {
        filteredProductsByYear = await getProductsByYear(selectedYears);
    }

    if (selectedCategories.length == 0) {
        filteredProductsByCategory = await getAllProducts();
    } else {
        filteredProductsByCategory = await getProductsByCategory(selectedCategories);
    }

    if (selectedBrands.length == 0) {
        filteredProductsByBrand = await getAllProducts();
    } else {
        filteredProductsByBrand = await getProductsByBrand(selectedBrands);
    }

    let filteredProductsByPrice = await getProductsByPrice(minPrice, maxPrice);
    console.log(filteredProductsByYear);
    console.log(filteredProductsByCategory);
    console.log(filteredProductsByBrand);
    console.log(filteredProductsByPrice);

    // Filtrer les produits qui correspondent à tous les filtres
    let productsToShow = filteredProductsByYear.filter(product => 
        filteredProductsByBrand.some(product2 => product2.product_id === product.product_id) &&
        filteredProductsByCategory.some(product2 => product2.product_id === product.product_id) &&
        filteredProductsByPrice.some(product2 => product2.product_id === product.product_id)
    );

    // // Afficher les produits dans la table
    console.log(productsToShow.length);
    fillTable('containerProduits', productsToShow)
}

// Fonction pour récupérer les produits en fonction des années sélectionnées
async function getProductsByYear(years) {
    let products = [];
    await years.forEach(year => {
        fetch('https://dev-vallee211.users.info.unicaen.fr/bikestores/products/years/'+year+'?key=e8f1997c763', {method: "GET"})
        .then(response => response.json())
        .then(data => {
            data.forEach(product => {
                products.push(product);
            });
        })
        .catch(error => console.error('Error:', error));
    });
    
    return products;
}

// Fonction pour récupérer les produits en fonction des marques sélectionnées
async function getProductsByBrand(brands) {
    let products = [];
    await brands.forEach(brand => {
        fetch('https://dev-vallee211.users.info.unicaen.fr/bikestores/products/brands/'+brand+'?key=e8f1997c763', {method: "GET"})
        .then(response => response.json())
        .then(data => {
            data.forEach(product => {
                products.push(product);
            });
        })
        .catch(error => console.error('Error:', error));
    });
    
    return products;
}

// Fonction pour récupérer les produits en fonction des catégories sélectionnées
async function getProductsByCategory(categories) {
    let products = [];
    await categories.forEach(category => {
        fetch('https://dev-vallee211.users.info.unicaen.fr/bikestores/products/categories/'+category+'?key=e8f1997c763', {method: "GET"})
        .then(response => response.json())
        .then(data => {
            data.forEach(product => {
                products.push(product);
            });
        })
        .catch(error => console.error('Error:', error));
    });
    
    return products;
}

// Fonction pour récupérer les produits en fonction de la plage de prix sélectionnée
async function getProductsByPrice(minPrice, maxPrice) {
    let products = [];
    await fetch('https://dev-vallee211.users.info.unicaen.fr/bikestores/products/price/'+minPrice+'/'+maxPrice+'?key=e8f1997c763', {method: "GET"})
    .then(response => response.json())
    .then(data => {
        data.forEach(product => {
            products.push(product);
        });
    })
    .catch(error => console.error('Error:', error));
    
    return products;
}

// Fonction pour récupérer tous les produits via l'api
async function getAllProducts() {
    let result;
    await fetch('https://dev-vallee211.users.info.unicaen.fr/bikestores/products?key=e8f1997c763', {method: "GET"})
    .then(response => response.json())
    .then(data => {
        result = data;
    })
    .catch(error => console.error('Error:', error));
    return result;
}

function setCookie(name, value, daysToExpire, path="/") {
    var expires = "";
    if (daysToExpire) {
        var date = new Date();
        date.setTime(date.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    
    document.cookie = name + "=" + value + expires + "; path="+path;
}

function getCookie(name) {
    var nameEQ = name + "=";
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1, cookie.length);
        }
        if (cookie.indexOf(nameEQ) === 0) {
            return cookie.substring(nameEQ.length, cookie.length);
        }
    }
    return null;
}

function deleteCookie(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}

function toggleMenu() {
    let menu = document.querySelector('.dropdown-menu');
    if (menu.classList.contains('selected')) {
        menu.classList.remove('selected');
    } else {
        menu.classList.add('selected');
    }
}
function afficheMenu() {
    let employee_role = getCookie('employee_role');
    let menu = document.querySelector('#menu');
    if (employee_role == null) {
        // menu de client
        menu.innerHTML = '<div class="container"><!-- Nom de l\'entreprise --><a class="navbar-brand" href="/">Bikestores</a><!-- Bouton de navigation sur mobile --><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><!-- Menu --><div class="collapse navbar-collapse" id="navbarNavDropdown"><ul class="navbar-nav mr-auto"><!-- Accueil --><li class="nav-item"><a class="nav-link" href="/">Home</a></li><!-- Catalogue --><li class="nav-item"><a class="nav-link" href="catalog.html">Catalog</a></li></ul></div></div>';
    } else {
        if (employee_role == 'employee') {
            menu.innerHTML = '<div class="container"><!-- Nom de l\'entreprise --><a class="navbar-brand" href="/">Bikestores</a><!-- Bouton de navigation sur mobile --><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><!-- Menu --><div class="collapse navbar-collapse" id="navbarNavDropdown"><ul class="navbar-nav mr-auto"><!-- Accueil --><li class="nav-item"><a class="nav-link" href="/">Home</a></li><!-- Catalogue --><li class="nav-item"><a class="nav-link" href="catalog.html">Catalog</a></li><!-- Modification Base De Données --><li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" onclick="toggleMenu()" aria-haspopup="true" aria-expanded="false">Modifier la base de données</a><div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"><!-- Sous-menu --><a class="dropdown-item" href="modifProducts.html">Products</a><a class="dropdown-item" href="modifBrands.html">Brands</a><a class="dropdown-item" href="modifCategories.html">Categories</a><a class="dropdown-item" href="modifStores.html">Stores</a><a class="dropdown-item" href="#">Stocks</a></div></li></ul></div></div>';
        } else if (employee_role == 'chief') {

        } else if (employee_role == 'it') {
            
        }
    }
}

function loadTableData(pageName, method) {
    document.querySelector('#tableData').innerHTML = "";
    // Effectuer une requête pour récupérer les données de la table
    fetch(`https://dev-vallee211.users.info.unicaen.fr/bikestores/${pageName}?limit=1&key=e8f1997c763`, { method: "GET" })
        .then(response => response.json())
        .then(data => {
            // Créer le formulaire
            const form = document.createElement('form');
            form.id = 'dataForm';
            console.log(data);
            // Créer un champ d'entrée pour chaque champ de la table
            let first = true;
            if (method == 'add') {
                Object.keys(data[0]).forEach(field => {
                    if (first) {
                        first = false;
                    } else {
                        if (field.includes('id')) {
                            const input = document.createElement('input');
                            input.type = 'number';
                            input.name = field;
                            input.placeholder = field;
                            form.appendChild(input);
                        } else {
                            const input = document.createElement('input');
                            input.type = 'text';
                            input.name = field;
                            input.placeholder = field;
                            form.appendChild(input);
                        }
                    } 
                });

                const addButton = document.createElement('button');
                addButton.textContent = 'Ajouter';
                addButton.addEventListener('click', () => sendData(pageName, 'POST'));
                document.querySelector('#tableData').appendChild(addButton);
            } else if (method == 'update') {
                Object.keys(data[0]).forEach(field => {
                    if (first) {
                        first = false;
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.name = field;
                        input.placeholder = field;
                        form.appendChild(input);
                    }
                });

                const updateButton = document.createElement('button');
                updateButton.textContent = 'Modifier';
                updateButton.addEventListener('click', () => getThingToUpdate(pageName));
                document.querySelector('#tableData').appendChild(updateButton);
            } else if (method == 'delete') {
                const input = document.createElement('input');
                input.type = 'number';
                input.name = 'id';
                input.placeholder = 'id_'+pageName+ ' to delete';
                form.appendChild(input);

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Supprimer';
                deleteButton.addEventListener('click', () => sendData(pageName, 'DELETE'));
                document.querySelector('#tableData').appendChild(deleteButton);
            }

            // Ajouter le formulaire et les boutons à la page
            document.querySelector('#tableData').appendChild(form);
        })
        .catch(error => console.error('Error:', error));
}

function sendData(pageName, method, id=null) {
    const formData = new FormData(document.getElementById('dataForm'));
    const data = {};

    // Convertir les données du formulaire en objet JSON
    formData.forEach((value, key) => {
        data[key] = value;
    });

    // Effectuer la requête correspondante
    if (method == 'POST') {
        fetch(`https://dev-vallee211.users.info.unicaen.fr/bikestores/${pageName}?key=e8f1997c763`, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => alert(pageName+' has been add successfully'))
        .catch(error => console.error('Error:', error));
    } else if (method == 'PUT') {
        fetch(`https://dev-vallee211.users.info.unicaen.fr/bikestores/${pageName}/${id}?key=e8f1997c763`, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => alert(pageName+' has been update successfully'))
        .catch(error => console.error('Error:', error));
    } else if (method == 'DELETE') {
        fetch(`https://dev-vallee211.users.info.unicaen.fr/bikestores/${pageName}/${data.id}?key=e8f1997c763`, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => alert(pageName+' has been delete successfully'))
        .catch(error => console.error('Error:', error));
    }
    
}

function getThingToUpdate(pageName, id=null) {
    if (id == null) {
        const formData = new FormData(document.getElementById('dataForm'));
        formData.forEach((value, key) => {
            id = value;
        });
    }
    
    document.querySelector('#tableData').innerHTML = "";
    // Effectuer une requête pour récupérer les données de la table
    fetch(`https://dev-vallee211.users.info.unicaen.fr/bikestores/${pageName}/${id}?key=e8f1997c763`, { method: "GET" })
        .then(response => response.json())
        .then(data => {
            // Créer le formulaire
            const form = document.createElement('form');
            form.id = 'dataForm';
            console.log(data);
            // Créer un champ d'entrée pour chaque champ de la table
            let first = true;
            Object.keys(data).forEach(field => {
                if (first) {
                    first = false;
                } else {
                    if (field.includes('id')) {
                        const input = document.createElement('input');
                        input.type = 'number';
                        input.name = field;
                        input.value = data[field];
                        form.appendChild(input);
                    } else {
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.name = field;
                        input.value = data[field];
                        form.appendChild(input);
                    }
                } 
            });

            const updateButton = document.createElement('button');
            updateButton.textContent = 'Modifier';
            updateButton.addEventListener('click', () => sendData(pageName, 'PUT', id));

            // Ajouter le formulaire et les boutons à la page
            document.querySelector('#tableData').appendChild(form);
            document.querySelector('#tableData').appendChild(updateButton);
        })
        .catch(error => console.error('Error:', error));
}

