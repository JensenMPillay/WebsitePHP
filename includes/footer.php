<?php
$reqPages = $pdo->query('SELECT * FROM pages');
$pages = $reqPages->fetchAll(PDO::FETCH_ASSOC);
if (!isset($_SESSION['user_id'])) {
    array_pop($pages);
}

$reqCategories = $pdo->query('SELECT * FROM categories');
$categories = $reqCategories->fetchAll(PDO::FETCH_ASSOC);

$reqSocialNetworks = $pdo->query('SELECT * FROM socialnetworks');
$SocialNetworks = $reqSocialNetworks->fetchAll(PDO::FETCH_ASSOC);

?> <!-- Footer -->
<div id="footer" class="m-2">
    <div class="container-fluid">
        <div class="row">
            <ul class="col list-group list-group-flush">
                <li class="list-group-item text-bg-dark text-secondary-emphasis">Plan du Site</li>
                <?php foreach ($pages as $page) {
                ?>
                    <li class="list-group-item text-bg-dark text-secondary-emphasis">
                        <a id=<?php echo $page['page_id'] ?> class="link text-decoration-none text-secondary-emphasis" href=<?php echo "/website/" . $page['page_path'] ?>><?php echo $page['page_name'] ?></a>
                    </li>
                <?php
                } ?>
            </ul>
            <ul class="col list-group list-group-flush">
                <li class="list-group-item text-bg-dark text-secondary-emphasis">Catégories</li>
                <?php foreach ($categories as $category) {
                ?>
                    <li class="list-group-item text-bg-dark text-secondary-emphasis">
                        <a id=<?php echo $category['category_id'] ?> class="link text-decoration-none text-secondary-emphasis" href="/website/pages/category/category.php?search=&cat_search=<?php echo $category['category_name']; ?>"><?php echo $category['category_name'] ?></a>
                    </li>
                <?php
                } ?>
            </ul>
            <ul class=" col list-group list-group-flush">
                <li class="list-group-item text-bg-dark text-secondary-emphasis">An item</li>
                <li class="list-group-item text-bg-dark text-secondary-emphasis">A second item</li>
                <li class="list-group-item text-bg-dark text-secondary-emphasis">A third item</li>
                <li class="list-group-item text-bg-dark text-secondary-emphasis">A fourth item</li>
            </ul>
            <ul class="col list-group list-group-flush">
                <li class="list-group-item text-bg-dark text-secondary-emphasis">Réseaux Sociaux</li>
                <?php foreach ($SocialNetworks as $SocialNetwork) {
                ?>
                    <li class="list-group-item text-bg-dark text-secondary-emphasis">
                        <a id=<?php echo $SocialNetwork['sn_id'] ?> href="<?php echo $SocialNetwork['sn_url'] ?>" target="_blank" class="link text-decoration-none text-secondary-emphasis">
                            <?php echo $SocialNetwork['sn_svg'] ?>
                            <span><?php echo ucfirst($SocialNetwork['sn_name']) ?></span>
                        </a>
                    </li>
                <?php
                } ?>
            </ul>
        </div>
    </div>
    <!-- Footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <script>
        function getCurrentURL() {
            return window.location.pathname;
        }
        if (document.getElementsByClassName("navbar")) {
            setTimeout(() => {
                const url = getCurrentURL();
                const urlTable = url.split("/");
                const pageExt = urlTable.slice(-1).pop();
                const page = pageExt.split(".")[0];
                const navHTML = document.getElementsByClassName("navbar-nav");
                const navArray = Array.from(navHTML);
                const lisArray = Array.from(navArray[0].children);
                switch (page) {
                    case "index":
                        lisArray[0].children[0].classList.add("active");
                        break;
                    case "contact":
                        lisArray[1].children[0].classList.add("active");
                        break;
                    case "cv":
                        lisArray[2].children[0].classList.add("active");
                        break;
                    case "category":
                        lisArray[3].children[0].classList.add("active");
                        break;
                }
            }, "1");
        };

        if (document.getElementById("search_bar")) {
            document.getElementById("search_bar").addEventListener("submit", function(e) {
                e.preventDefault(); // Rechargement STOP
                var data = new FormData(this); // Récupération de toutes les entrées du formulaire
                var xhr = new XMLHttpRequest(); // Creation Objet AJAX
                xhr.onreadystatechange = function() {
                    // Si Changement :
                    if (this.readyState == 4 && this.status == 200) {
                        // Send & Succés
                        // console.log(this.response);
                        displayResults(this.response);
                        var $resultats = this.response;
                    } else if (this.readyState == 4) {
                        // Send & Erreur
                        console.log("Une erreur est survenue...");
                    }
                };
                xhr.open("POST", "/website/functions/search.php", true); // Methode et Action PHP
                xhr.responseType = "json"; // Format de la réponse
                // xhr.responseType = "text";
                // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(data);
                return false;
            });

            function displayResults(dataTable) {
                // Récupération des données des résultats
                var data = dataTable.donnees[0];
                console.log(data);
                // Connexion à l'élément HTML
                var resultsContainer = document.getElementById("results-container");
                // Supprime les résultats à chaque nouvelle recherche
                resultsContainer.innerHTML = "";
                // Ajout d'un titre "Résultat"
                resultsContainer.innerHTML += "<h2 class='text-center'>Résultats</h2>";
                // Cas où il n'y a pas de résultats ("champ vide ou pas de résultats")
                if (data.length === 0) {
                    resultsContainer.innerHTML = "<p class='text-center text-muted text-secondary-emphasis'>Aucun résultat trouvé.</p>";
                    return;
                }
                // Pour chaque résultat, créer une card avec les résultats
                for (var i = 0; i < data.length; i++) {
                    var result = data[i];
                    var resultHTML = "";
                    resultHTML += "<div class='card text-bg-dark border-light col-5 col-md-3 m-2'>";
                    resultHTML += "<img src='/website/uploads/" + result.img_product + "' class='card-img-top mt-3' alt='...'>";
                    resultHTML += "<div class='card-body'>";
                    resultHTML += "<h5 class='card-title'>" + result.name_product + "</h5>";
                    resultHTML += "<p class='card-text'>" + result.desc_product + "</p>";
                    resultHTML += "<a href='" + result.url + "' class='btn btn-primary'>En savoir plus</a>";
                    resultHTML += "</div>";
                    resultHTML += "</div>";
                    resultsContainer.innerHTML += resultHTML;
                }
            }
        }
    </script>

    </body>

    </html>